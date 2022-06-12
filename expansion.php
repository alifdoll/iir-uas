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
require_once('Porter2.php');

use markfullmer\porter2\Porter2;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Tokenization\WhitespaceTokenizer;

$data = [
    'Information technology in health promotion',
    'Information Technology and Productivity: A Review of the Literature',
    'Smart City and information technology: A review'
];

foreach ($data as $index => $d) {
    $stemmed = Porter2::stem($d);
    $data[$index] = $stemmed;
}

$test = "The brown fox jumps over";
$stemmed_stuff = Porter2::stem($test);
var_dump($test);
die;

$tf = new TokenCountVectorizer(new WhitespaceTokenizer());
$tf->fit($data);
$tf->transform($data);


$vocab = $tf->getVocabulary();
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

        </tbody>
    </table>

</body>

</html>