<?php

use markfullmer\porter2\Porter2;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Math\Distance\Euclidean;
use Phpml\Tokenization\WhitespaceTokenizer;

require_once __DIR__ . '/vendor/autoload.php';

require_once('Porter2.php');

function getJournals($keyword = "", $method = 'euclidean')
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


    $journals = [];

    $sql = 'SELECT * FROM data';
    $res = $conn->query($sql);

    $stemmed_titles = [];
    if ($res->num_rows > 0) {

        // var_dump($journals);
        // echo 'ROWS';
        // echo '<br>';
        if ($keyword != "") {
            while ($row = $res->fetch_assoc()) {
                $stemmed_title = Porter2::stem($row['title']);
                $stemmed_titles[] = $stemmed_title;
                $journals[] = [
                    'title' => $row['title'],
                    'number_citations' => $row['number_citations'],
                    'abstract' => $row['abstract'],
                    'authors' => $row['authors']
                ];
            }
            $stemmed_titles[] = $keyword;
        } else {
            $journals = $res->fetch_all(MYSQLI_ASSOC);
        }
    }

    if ($keyword != "") {
        $tf = new TokenCountVectorizer(new WhitespaceTokenizer());
        $tf->fit($stemmed_titles);
        $tf->transform($stemmed_titles);

        $tf_idf = new TfIdfTransformer($stemmed_titles);
        $tf_idf->transform($stemmed_titles);

        $euclidean = new Euclidean();
        $distance = [];
        $idx = count($stemmed_titles) - 1;

        if ($method != 'euclidean') {
            foreach ($stemmed_titles as $index => $data) {
                $numerator = 0.0;
                $denom_wkq = 0.0;
                $denom_wkj = 0.0;
                for ($i = 0; $i < 10; $i++) {
                    $numerator += $stemmed_titles[$idx][$i] * $stemmed_titles[$index][$i];
                    $denom_wkq += pow($stemmed_titles[$idx][$i], 2);
                    $denom_wkj += pow($stemmed_titles[$index][$i], 2);
                }

                if ((0.5 * $denom_wkq + 0.5 * $denom_wkj) != 0) {
                    $distance[] = $numerator / (0.5 * $denom_wkq + 0.5 * $denom_wkj);
                } else $distance[] = 0;
            }
        } else {
            foreach ($stemmed_titles as $index => $data) {
                if ($index == $idx) break;
                $distance[] = $euclidean->distance($data, $stemmed_titles[$idx]);
            }
        }

        array_pop($stemmed_titles);

        $final_journal = [];
        foreach ($journals as $i => $row) {
            $final_journal[] = [
                'title' => $row['title'],
                'number_citations' => $row['number_citations'],
                'abstract' => $row['abstract'],
                'authors' => $row['authors'],
                'similarity_score' => $distance[$i]
            ];
        }
        usort($final_journal, fn ($doc, $query) => $doc['similarity_score'] > $query['similarity_score']);
        return $final_journal;
    }
    return $journals;
}
