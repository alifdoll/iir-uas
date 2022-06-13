<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UAS IIR</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>


<?php

use markfullmer\porter2\Porter2;

include_once('Porter2.php');
include_once('journals.php');
include_once('query_expansions.php');

$keyword = '';
$method = '';
$query_expansions = [];
if (isset($_GET['keyword']) && isset($_GET['method'])) {
    $keyword = $_GET['keyword'];
    $method = $_GET['method'];
}

$journals = getJournals($keyword, $method);

if ($keyword != '') {
    $top_3 = array_slice($journals, 0, 3);
    $query_expansions = getQueryExpansions($keyword, $top_3);
}
?>

<body>

    <div class="container">
        <div class="row">
            <div class="col  d-flex justify-content-center">
                <h1>Welcome To Scientific Journal Search Engine</h1>
            </div>
        </div>

        <div class="row">
            <div class="col  d-flex justify-content-center">
                <form method="GET" action="">
                    <p class="lead">Input Keyword <input type="text" name="keyword" value="<?php echo (isset($_GET["keyword"])) ? $_GET["keyword"] : "";  ?>"> <input type="submit">
                        <!-- <br> -->
                    </p>
                    <input type="radio" id="euclidean" name="method" value="euclidean" checked="true">
                    <label for="html">Euclidean</label>
                    <input type="radio" id="dice" name="method" value="dice">
                    <label for="css">Dice</label><br>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <h1>The Search Result</h1>
                <aside class="float-right">
                    <?php if (count($query_expansions) > 0) : ?>
                        <h3>Related Search</h3>
                        <?php foreach ($query_expansions as $q) : ?>
                            <a href="?keyword=<?= $q ?>&method=<?= $method ?>"><?= $q; ?></a>
                            <br>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </aside>
                <?php foreach ($journals as $j) : ?>
                    <div class="card" style="width: 50rem;">
                        <div class="card-body">
                            <h3 class="card-title">Title : <?= $j['title']; ?></h3>
                            <p class="card-text">Authors : <?= $j['authors']; ?></p>
                            <p class="card-text">Abstract : <?= $j['abstract']; ?></p>
                            <p class="card-text">Number of Citation : <?= $j['number_citations']; ?></p>
                            <?php if ($keyword != '') : ?>
                                <p class="card-text">Similarity Score : <?= $j['similarity_score']; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <hr class="batas">
                <?php endforeach; ?>
                <!-- <div class="card" style="width: 50rem;">
                    <div class="card-body">
                        <h3 class="card-title">Title : Card title</h3>
                        <p class="card-text">Authors : Card title</p>
                        <p class="card-text">Abstract : Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <p class="card-text">Number of Citation :123</p>
                        <p class="card-text">Similarity Score : 0.0001</p>
                    </div>
                </div> -->
            </div>
        </div>
    </div>



</body>

</html>