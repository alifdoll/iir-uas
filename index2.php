<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Kuis NTS IIR Genap 2021-2022</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/sl-slide.css">
    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
        .batas {
            border: 1px solid black;
            width: 50rem;
        }

        aside {
            width: 30%;
            padding-left: 15px;
            margin-left: 15px;
            float: right;
            /* font-style: italic; */
            /* background-color: lightgray; */
        }
    </style>
</head>

<body>
    <!--Header-->
    <header class="navbar navbar-fixed-top">
        <div class="nav-collapse collapse pull-right">
            <ul class="nav">
                <li class="active"><a href="index2.php">Crawling Data</a></li>
            </ul>
        </div>
    </header>
    <!-- /header -->

    <!--Services-->
    <section id="services">
        <div class="container">
            <div class="center gap">
                <h3>Welcome to Scientific Journals Search Engine</h3>
                <form method="GET" action="index2.php">
                    <p class="lead">Input Keyword <input type="text" name="keyword" value="<?php echo (isset($_GET["keyword"])) ? $_GET["keyword"] : "";  ?>"> <input type="submit">
                        <!-- <br> -->
                    </p>
                    <input type="hidden" id="data" name="data" value="0">
                    <input type="radio" id="jaccard" name="method" value="jaccard" checked="true">
                    <label for="html">Euclidean</label>
                    <input type="radio" id="manhattan" name="method" value="manhattan">
                    <label for="css">Dice</label><br>
                </form>

                <?php
                //ISIKAN CODE ANDA DISINI



                use MathPHP\Statistics\Distance;
                use Phpml\CrossValidation\Split;
                use Phpml\FeatureExtraction\TfIdfTransformer;
                use Phpml\FeatureExtraction\TokenCountVectorizer;
                use Phpml\Tokenization\WhitespaceTokenizer;
                use Sastrawi\Stemmer\StemmerFactory;
                use Sastrawi\StopWordRemover\StopWordRemoverFactory;

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
                if (isset($_GET['keyword'])) {
                    $keyword = str_replace(' ', '+', $_GET["keyword"]);
                }

                $start = $_GET['data'];
                // echo $start;
                $url = "https://scholar.google.com/scholar?start=$start&q=$keyword&hl=en&as_sdt=0,5&as_rr=1";
                // $url = "https://www.sciencedirect.com/science/article/abs/pii/S1367578807000077";
                $html = file_get_html($url);
                $news = [];

                function str_contains(string $haystack, string $needle): bool
                {
                    return '' === $needle || false !== strpos($haystack, $needle);
                }


                foreach ($html->find('div[class="gs_ri"]') as $index => $berita) {


                    $title = $berita->find('a', 0)->innertext;
                    $link = $berita->find('a', 0)->href;
                    $cite = $berita->find('div[class="gs_fl"]', 0);
                    $cited = explode(" ",  $cite->find('a', 2)->innertext)[2];
                    $authors = "tes";
                    // $authors = explode(" ",  $cite->find('a', 2)->innertext)[2];
                    // $abstract = explode(" ",  $cite->find('a', 2)->innertext)[2];



                    $cut = explode("/", $link);
                    // var_dump($cut[2]);
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
                    $news[] = array(
                        "title" => $title,
                        "link" => $link,
                        "abstract" => $abstract,
                        "cite" => $cited
                    );
                    // echo $title;

                    $stmt = $conn->prepare("INSERT INTO journals (title, link, cite, keyword, author, abstract) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssisss", $title, $link, $cited, $keyword, $authors, $abstract);
                    $stmt->execute();
                }



                ?>
            </div>
        </div>
    </section>
    <!--/Services-->
    <h1>The Search Result</h1>
    <aside>
        <h3>Related Search</h3>
        <a href="#">Query Expansion 1</a>
        <br>
        <a href="#">Query Expansion 2</a>
        <br>
        <a href="#">Query Expansion 3</a>
        <br>
        <a href="#">Query Expansion 4</a>
        <br>
        <a href="#">Query Expansion 5</a>
        <br>
    </aside>
    <?php if (count($news) > 0) : ?>
        <?php foreach ($news as $berita) : ?>
            <tr>
                <!-- <td><?= $berita["title"] ?> </td>
                <td><a href="<?= $berita["link"] ?>"><?= $berita["link"] ?> </a></td>
                <td><?= $berita["abstract"] ?> </td>
                <td><?= $berita["cite"]; ?></td> -->
                <div class="card" style="width: 50rem;">
                    <div class="card-body">
                        <h3 class="card-title">Title : <?= $berita["title"] ?></h3>
                        <p class="card-text">Authors : Card title</p>
                        <p class="card-text">Abstract : <?= $berita["abstract"] ?></p>
                        <p class="card-text">Number of Citation : <?= $berita["cite"]; ?></p>
                        <p class="card-text">Similarity Score : 0.0001</p>
                    </div>
                </div>
                <hr class="batas">

            </tr>
        <?php endforeach; ?>
    <?php endif; ?>

    <nav aria-label="Page navigation example">
        <ul class="pagination">
        <?php if ($start >= 10 && $start >0) : ?>
            <li class="page-item"><a class="page-link" href="?keyword=pdf&data=<?= $start - 10?>">Previous</a></li>
        <?php endif; ?>
            <li class="page-item"><a class="page-link" href="?keyword=pdf&data=10">1</a></li>
            <li class="page-item"><a class="page-link" href="?keyword=pdf&data=20">2</a></li>
            <li class="page-item"><a class="page-link" href="?keyword=pdf&data=30">3</a></li>
        <?php if ($start < 30 && $start >=0) : ?>
            <li class="page-item"><a class="page-link" href="?keyword=pdf&data=<?= $start + 10?>">Next</a></li>
        <?php endif; ?>
        </ul>
    </nav>
    <!-- <table class="table table-dark">
        <thead>
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Link</th>
                <th scope="col">Abstract</th>
                <th scope="col">Number of citation</th>

            </tr>
        </thead>
        <tbody>
            <?php if (count($news) > 0) : ?>
                <?php foreach ($news as $berita) : ?>
                    <tr>
                        <td><?= $berita["title"] ?> </td>
                        <td><a href="<?= $berita["link"] ?>"><?= $berita["link"] ?> </a></td>
                        <td><?= $berita["abstract"] ?> </td>
                        <td><?= $berita["cite"]; ?></td>

                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>

        </tbody>
    </table> -->

</body>

</html>