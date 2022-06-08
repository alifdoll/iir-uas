<?php
require_once __DIR__ . '/vendor/autoload.php';
include_once('simple_html_dom.php');

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
    $link = $j['link'];
    $cut = explode("/", $link);
    if (str_contains($link, 'pdf')) {
        $abstract = "Tidak bisa crawl file pdf";
    } else {
        if ($cut[2] == "link.springer.com") {
            $opts = array(
                'http' => array(
                    'method' => "GET",
                    'header' => "User-Agent: lashaparesha api script\r\n"
                )
            );

            $context = stream_context_create($opts);

            // $url = http://www.giantbomb.com/api/..........
            // $link2 = "https://link.springer.com/article/10.1057/jors.1992.4";
            $html2 = file_get_html($link, false, $context);
            // echo $file;
            // // echo file_get_html("www.google.com", false, $context);
            // $html2 = file_get_html($link, false, $context);
            foreach ($html2->find('div[id="Abs1-content"]') as $index2 => $berita2) {
                $abstract = $berita2->find('p', 0)->innertext;

                // echo $abstract;
            }
        } else if ($cut[2] == "dl.acm.org") {

            $opts = array(
                'http' => array(
                    'method' => "GET",
                    'header' => "User-Agent: lashaparesha api script\r\n"
                )
            );

            $context = stream_context_create($opts);

            // $url = http://www.giantbomb.com/api/..........
            // $link2 = "https://link.springer.com/article/10.1057/jors.1992.4";
            $html2 = file_get_html($link, false, $context);
            // echo $file;
            // // echo file_get_html("www.google.com", false, $context);
            // $html2 = file_get_html($link, false, $context);
            foreach ($html2->find('div[class="abstractSection abstractInFull"]') as $index2 => $berita2) {
                $abstract = $berita2->find('p', 0)->innertext;

                // echo $abstract;
            }
        } else {
            $abstract = "";
        }
    }

    // SETELAH CRAWL ABSTRACT DAN AUTHOR
    // MASUKKAN KE TABLE JOURNALS

    // INSERT ......
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
