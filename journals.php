<?php

use markfullmer\porter2\Porter2;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Math\Distance\Euclidean;
use Phpml\Tokenization\WhitespaceTokenizer;

require_once __DIR__ . '/vendor/autoload.php';

require_once('Porter2.php');
include_once('simple_html_dom.php');

function connectDB()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "iir_uas";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function getJournals($keyword = "", $method = 'euclidean', $offset = 0)
{
    $conn = connectDB();

    $journals = [];

    $sql = "SELECT * FROM journal_data LIMIT 5 OFFSET $offset";
    $res = $conn->query($sql);

    $titles = [];
    if ($res->num_rows > 0) {
        if ($keyword != "") {
            while ($row = $res->fetch_assoc()) {
                $stemmed_title = Porter2::stem($row['title']);
                $titles[] = $stemmed_title;
                $journals[] = [
                    'title' => $row['title'],
                    'cite' => $row['cite'],
                    'abstract' => $row['abstract'],
                    'authors' => $row['authors']
                ];
            }
            $titles[] = $keyword;
        } else {
            $journals = $res->fetch_all(MYSQLI_ASSOC);
        }
    }

    if ($keyword != "") {
        $tf = new TokenCountVectorizer(new WhitespaceTokenizer());
        $tf->fit($titles);
        $tf->transform($titles);

        $tf_idf = new TfIdfTransformer($titles);
        $tf_idf->transform($titles);

        $distance = [];
        $query_index = count($titles) - 1;

        if ($method != 'euclidean') {
            // DICE COEFFICIENT
            foreach ($titles as $index => $data) {
                $numerator = 0;
                $denom_wkq = 0.0;
                $denom_wkj = 0.0;

                for ($i = 0; $i < count($titles[$index]); $i++) {
                    $numerator += $titles[$query_index][$i] * $titles[$index][$i];
                    $denom_wkq += pow($titles[$query_index][$i], 2);
                    $denom_wkj += pow($titles[$index][$i], 2);
                }

                // 0 * 0.123532
                // 0.12376 * 0 
                // 
                if ((0.5 * $denom_wkq + 0.5 * $denom_wkj) != 0) {
                    $distance[] = $numerator / (0.5 * $denom_wkq + 0.5 * $denom_wkj);
                } else $distance[] = 0;
            }
        } else {
            // EUCLIDEAN DISTANCE
            $euclidean = new Euclidean();
            foreach ($titles as $index => $data) {
                $distance[] = $euclidean->distance($data, $titles[$query_index]);
            }
        }

        array_pop($titles);

        $final_journal = [];
        foreach ($journals as $i => $row) {
            $final_journal[] = [
                'title' => $row['title'],
                'cite' => $row['cite'],
                'abstract' => $row['abstract'],
                'authors' => $row['authors'],
                'similarity_score' => $distance[$i]
            ];
        }

        if ($method != 'euclidean') {
            usort($final_journal, fn ($doc, $query) => $doc['similarity_score'] > $query['similarity_score']);
        } else {
            usort($final_journal, fn ($doc, $query) => $doc['similarity_score'] < $query['similarity_score']);
        }
        return $final_journal;
    }
    return $journals;
}

function getJournalsCount()
{
    $conn = connectDB();
    $sql = "SELECT count(*) FROM journal_data ";
    $res = $conn->query($sql);

    $count = 0;
    if ($res->num_rows > 0) {
        $count = $res->fetch_array()[0];
    }
    return $count;
}

function getCrawlCount()
{
    $conn = connectDB();
    $sql = "SELECT count(*) FROM crawl";
    $res = $conn->query($sql);

    $count = 0;
    if ($res->num_rows > 0) {
        $count = $res->fetch_array()[0];
    }
    return $count;
}

// FUNCTION CRAWL GOOGLE SCHOLAR
function crawl($keyword, $page = 0)
{

    error_reporting(E_ERROR | E_PARSE);
    set_time_limit(300);

    $conn = connectDB();

    $url = "https://scholar.google.com/scholar?start=$page&q=$keyword&hl=en&as_sdt=0,5&as_rr=1";

    $html = file_get_html($url);

    foreach ($html->find('div[class="gs_ri"]') as $index => $journal) {
        $title = strip_tags($journal->find('a', 0)->innertext);
        $link = $journal->find('a', 0)->href;
        $cite = $journal->find('div[class="gs_fl"]', 0);
        $cited = explode(" ",  $cite->find('a', 2)->innertext)[2];

        $stmt = $conn->prepare("INSERT INTO crawl (title, link, cite, keyword) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $title, $link, $cited, $keyword);
        $stmt->execute();
    }
}


// FUNCTION MEMASUKKAN DATA ABSTRACT DARI HASIL CRAWL KE DATABASE
function insertDatabase($offset = 0)
{
    $conn = connectDB();
    $sql = "SELECT * FROM crawl WHERE crawled = 'NOT YET'";
    $res = $conn->query($sql);

    $titles = [];

    $journals = [];

    if ($res->num_rows > 0) {
        $journals = $res->fetch_all(MYSQLI_ASSOC);
    }
    // $data = [];

    foreach ($journals as $j) {
        $link = $j['link'];
        $cut = explode("/", $link);
        $found_abs = false;
        $found_authors = false;
        $data = [];
        try {
            if (!str_contains($link, 'pdf')) {
                $opts = array(
                    'http' => array(
                        'method' => "GET",
                        'header' => "Accept-language: en\r\n" .
                            "User-Agent:    Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6\r\n" .
                            "Cookie: foo=bar\r\n"
                    )
                );
                $context = stream_context_create($opts);

                $html = file_get_html($link, false, $context);
                $abstract = "";
                $authors = "-";

                foreach ($html->find('p') as  $p) {
                    $word_count = str_word_count($p);
                    $str_len = strlen($p);

                    if ($word_count > 80 && $word_count <= 300 && $str_len > 600 && $str_len <= 2400) {
                        $found_abs = true;
                        $abstract = strip_tags($p->plaintext);
                        break;
                    }
                }


                $data[] = [
                    "id" => $j['id'],
                    "title" => $j["title"],
                    "abstract" => $abstract,
                    "authors" => $authors,
                    "cite" => $j['cite']
                ];
            }
        } catch (\Throwable $th) {
            setCrawlFail($j["id"], $conn);
        }


        if ($found_abs) {
            insertJournalData($j["id"], $data, $conn);
        } else {
            setCrawlFail($j["id"], $conn);
        }
    }
}


// FUNCTION UNTUK MEMASUKKAN DATA KEDALAM DATABASE
function insertJournalData($id, $data, $conn)
{
    $stmt = $conn->prepare("INSERT INTO journal_data (title, abstract, authors, cite, crawl_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $data[0]["title"], $data[0]["abstract"], $data[0]["authors"], $data[0]["cite"], $id);
    $stmt->execute();

    $conn->query("UPDATE crawl SET crawled = 'SUCCESS' WHERE id = $id");
}

function setCrawlFail($id, $conn)
{
    $conn->query("UPDATE crawl SET crawled = 'FAIL' WHERE id = $id");
}
