<?php
require_once __DIR__ . '/vendor/autoload.php';
include_once('simple_html_dom.php');
error_reporting(E_ERROR | E_PARSE);
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iir_uas";

set_time_limit(300);
$jum_index = 0;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$keyword = "";
$start = '';
if (isset($_GET['keyword'])) {
    $keyword = str_replace(' ', '+', $_GET["keyword"]);
}

if (isset($_GET['data'])) {
    $start = $_GET['data'];
}

$url = "https://scholar.google.com/scholar?start=$start&q=$keyword&hl=en&as_sdt=0,5&as_rr=1";

$html = file_get_html($url);
$news = [];

$crawl = (isset($_GET['is_crawl'])) ? true : false;
// var_dump($crawl);
// die;
if ($crawl) {
    foreach ($html->find('div[class="gs_ri"]') as $index => $berita) {
        $title = strip_tags($berita->find('a', 0)->innertext);
        $link = $berita->find('a', 0)->href;
        $cite = $berita->find('div[class="gs_fl"]', 0);
        $cited = explode(" ",  $cite->find('a', 2)->innertext)[2];

        $stmt = $conn->prepare("INSERT INTO crawl (title, link, cite, keyword) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $title, $link, $cited, $keyword);
        $stmt->execute();
    }
}




$sql = 'SELECT * FROM crawl';
$res = $conn->query($sql);

$stemmed_titles = [];

$journals = [];

if ($res->num_rows > 0) {
    $journals = $res->fetch_all(MYSQLI_ASSOC);
}

foreach ($journals as $index => $j) {
    $jum_index += $index;
    $link = $j['link'];
    $cut = explode("/", $link);
    $data = [];
    try {
        if (str_contains($link, 'pdf')) {
            $abstract = "Tidak bisa crawl file pdf";
        } else {

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
            $found = false;
            foreach ($html->find('p') as  $p) {
                $word_count = str_word_count($p);
                if ($word_count > 200 && $word_count <= 300) {
                    $found = true;
                    // var_dump($j);
                    // echo "<br>";
                    // echo ($p);
                    // die;
                    $data[] = [
                        "id" => $j['id'],
                        "title" => $j["title"],
                        "abstract" => $p->plaintext,
                        "authors" => "authors_test",
                        "cite" => $j['cite']
                    ];
                }
            }

            // foreach ($html->find('span') as $p) {
            //     $word_count = str_word_count($p);
            //     if ($word_count > 200 && $word_count <= 300) {

            //         $found = true;
            //         $data[] = [
            //             "id" => $j['id'],
            //             "title" => $j["title"],
            //             "abstract" => $p,
            //             "authors" => "authors_test",
            //             "cite" => $j['cite']
            //         ];
            //     }
            // }

            // foreach ($html->find('article') as $p) {
            //     $word_count = str_word_count($p);
            //     if ($word_count > 200 && $word_count <= 300) {

            //         $found = true;
            //         $data[] = [
            //             "id" => $j['id'],
            //             "title" => $j["title"],
            //             "abstract" => $p,
            //             "authors" => "authors_test",
            //             "cite" => $j['cite']
            //         ];
            //     }
            // }
        }
    } catch (\Throwable $th) {
    }


    if ($found) {

        insertJournalData($j["id"], $data, $conn);
    }

    // SETELAH CRAWL ABSTRACT DAN AUTHOR
    // MASUKKAN KE TABLE JOURNALS

    // INSERT ......

}



$sql = 'SELECT * FROM journal_data';
$res = $conn->query($sql);


$data = [];

if ($res->num_rows > 0) {
    $data = $res->fetch_all(MYSQLI_ASSOC);
}

var_dump($jum_index);



function insertJournalData($id, $data, $conn)
{
    $stmt = $conn->prepare("INSERT INTO journal_data (title, abstract, authors, cite, crawl_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $data[0]["title"], $data[0]["abstract"], $data[0]["authors"], $data[0]["cite"], $id);
    $stmt->execute();
    // var_dump($conn->error_list);
}



// if ($res->num_rows > 0) {
//     while ($row = $res->fetch_assoc()) {
//         $cut = explode("/", $link);
//         if (str_contains($link, 'pdf')) {
//             $abstract = "Tidak bisa crawl file pdf";
//         } else {
//             if ($cut[2] == "link.springer.com") {
//                 $opts = array(
//                     'http' => array(
//                         'method' => "GET",
//                         'header' => "User-Agent: lashaparesha api script\r\n"
//                     )
//                 );

//                 $context = stream_context_create($opts);

//                 // $url = http://www.giantbomb.com/api/..........
//                 // $link2 = "https://link.springer.com/article/10.1057/jors.1992.4";
//                 $html2 = file_get_html($link, false, $context);
//                 // echo $file;
//                 // // echo file_get_html("www.google.com", false, $context);
//                 // $html2 = file_get_html($link, false, $context);
//                 foreach ($html2->find('div[id="Abs1-content"]') as $index2 => $berita2) {
//                     $abstract = $berita2->find('p', 0)->innertext;

//                     // echo $abstract;
//                 }
//             } else if ($cut[2] == "dl.acm.org") {

//                 $opts = array(
//                     'http' => array(
//                         'method' => "GET",
//                         'header' => "User-Agent: lashaparesha api script\r\n"
//                     )
//                 );

//                 $context = stream_context_create($opts);

//                 // $url = http://www.giantbomb.com/api/..........
//                 // $link2 = "https://link.springer.com/article/10.1057/jors.1992.4";
//                 $html2 = file_get_html($link, false, $context);
//                 // echo $file;
//                 // // echo file_get_html("www.google.com", false, $context);
//                 // $html2 = file_get_html($link, false, $context);
//                 foreach ($html2->find('div[class="abstractSection abstractInFull"]') as $index2 => $berita2) {
//                     $abstract = $berita2->find('p', 0)->innertext;

//                     // echo $abstract;
//                 }
//             } else {
//                 $abstract = "";
//             }
//         }

//         $journals[] = [
//             'id' => $row['id'],
//             'title' => $row['title'],
//             'link' => $row['link'],
//             'cite' => $row['cite'],
//             'keyword' => $row['keyword'],

//         ];
//     }
// }
