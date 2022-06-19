<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IIR UAS CRAWL</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>

<?php
// SET AGAR WARNING ATAU FATAL ERROR KETIKA CRAWL
// ATAU INSERT DATABASE BISA SKIP
error_reporting(E_ERROR | E_PARSE);

// SET BATAS LIMIT LOADING PAGE
// AGAR TIDAK DIBERHENTIKAN OTOMATIS OLEH APACHE
// KETIKA CRAWL ATAU INSERT DATABASE
set_time_limit(300);


require_once('journals.php');


$keyword = "";
$start = '';
if (isset($_GET['keyword'])) {
    $keyword = str_replace(' ', '+', $_GET["keyword"]);
    crawl($keyword);
}

if (isset($_GET['data'])) {
    $start = $_GET['data'];
}

if (isset($_GET['crawl_db'])) {
    insertDatabase();
}


$pages = getCrawlCount();
$page_count = round((int)$pages / 5);



?>

<body>

    <div class="container">
        <div class="row">
            <div class="col">
                <div class="col  d-flex justify-content-center">
                    <h1>Crawl Google Scholar</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="col  d-flex justify-content-center">
                    <form method="GET" action="">
                        <p class="lead">Input Keyword
                            <input type="text" name="keyword" value="<?php echo (isset($_GET["keyword"])) ? $_GET["keyword"] : "";  ?>">
                        </p>
                        <p class="lead">Insert Page
                            <input type="number" name="page" id="page" value=0>
                        </p>
                        <input type="submit">
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="col  d-flex justify-content-center">
                    <h1>Insert Crawled To Database</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="col  d-flex justify-content-center">
                    <form method="GET" action="">
                        <input type="hidden" value="crawl_db" name="crawl_db">
                        <input type="submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>


</html>