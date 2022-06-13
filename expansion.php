<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tets Query Expansion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>

<?php

require_once __DIR__ . '/vendor/autoload.php';
// require_once('Porter2.php');

use markfullmer\porter2\Porter2;
use MathPHP\Probability\Distribution\Continuous\Continuous;
use Nadar\Stemming\Stemm;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Tokenization\WhitespaceTokenizer;
use StopWords\StopWords;
use Wamania\Snowball\StemmerManager;

$data = [
    'Information technology in health promotion',
    'Information Technology and Productivity: A Review of the Literature',
    'Smart City and information technology: A review'
];

$query = 'technology';

foreach ($data as $index => $d) {
    $lowered = strtolower($d);
    // $stemmed = Stemm::stem($d, 'en');
    $stop_words_remover = new StopWords('en');
    $stopped = $stop_words_remover->clean($lowered);

    $data[$index] = $stopped;
}

// var_dump($data[1]);
// die;

$tf = new TokenCountVectorizer(new WhitespaceTokenizer());
$tf->fit($data);
$tf->transform($data);


$vocab = $tf->getVocabulary();

// $tfidf = new TfIdfTransformer($data);
// $tfidf->transform($data);

$data_new = [];

foreach ($vocab as $i => $vc) {
    $data_new[$vc] = array_sum(array_column($data, $i));
}

arsort($data_new);

$terms = [];
foreach ($data_new as $key => $d) {
    $terms[] = $key;
}


if (count($terms) > 1) {
    $terms = array_slice($terms, 0, 4);
}




$expansions = [];

foreach ($terms as $term) {
    if ($term == $query) continue;
    $expansions[] = $query . " " . $term;
}

var_dump($expansions);





?>

<body>

    <table class="table table-dark">
        <thead>
            <tr>
                <th scope="col">#</th>
                <?php foreach ($vocab as $vc) : ?>
                    <th scope="col"><?= $vc; ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $index => $d) : ?>
                <tr>
                    <th scope="row"><?= $index; ?></th>
                    <?php foreach ($d as $count) : ?>
                        <td><?= $count; ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td>#</td>
                <?php foreach ($vocab as $index => $vc) : ?>
                    <td><?php echo array_sum(array_column($data, $index)); ?></td>
                <?php endforeach; ?>
            </tr>
        </tbody>
    </table>

</body>

</html>