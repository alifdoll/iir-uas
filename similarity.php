<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once "hamming.php";

    use Phpml\FeatureExtraction\TokenCountVectorizer;
    use Phpml\Tokenization\WhitespaceTokenizer;
    use Phpml\FeatureExtraction\TfIdfTransformer;
    use Phpml\Math\Distance\Chebyshev;
    use Phpml\Math\Distance\Euclidean;
    use Phpml\Math\Distance\Manhattan;
    use Phpml\Math\Distance\Minkowski;
    use MathPHP\Statistics\Distance;

    $sample_data = [
        'dolar naik harga naik hasil turun',
        'harga naik harus gaji naik',
        'premium tidak pengaruh dolar',
        'harga laptop naik',
        'naik harga'
    ];


    $similarity_data = $sample_data;
    $tf = new TokenCountVectorizer(new WhitespaceTokenizer());
    $tf->fit($similarity_data);
    $tf->transform($similarity_data);



    $vocab = $tf->getVocabulary();

    $tfidf_data = $similarity_data;
    $tfidf = new TfIdfTransformer($tfidf_data);
    $tfidf->transform($tfidf_data);

    $euclidean = new Euclidean();
    $euclidean_res = [];
    foreach ($tfidf_data as $index => $data) {
        if ($index == 4) break;
        $euclidean_res[] = $euclidean->distance($data, $tfidf_data[4]);
    }


    $manhattan = new Manhattan();
    $manhattan_res = [];
    foreach ($tfidf_data as $index => $data) {
        if ($index == 4) break;
        $manhattan_res[] = $manhattan->distance($data, $tfidf_data[4]);
    }

    $chebyshev = new Chebyshev();
    $chebyshev_res = [];
    foreach ($tfidf_data as $index => $data) {
        if ($index == 4) break;
        $chebyshev_res[] = $chebyshev->distance($data, $tfidf_data[4]);
    }


    $minkowski = new Minkowski();
    $minkowski_res = [];
    foreach ($tfidf_data as $index => $data) {
        if ($index == 4) break;
        $minkowski_res[] = $minkowski->distance($data, $tfidf_data[4]);
    }

    $canberra_res = [];
    foreach ($tfidf_data as $index => $data) {
        if ($index == 4) break;
        $canberra_res[] = Distance::canberra($data, $tfidf_data[4]);
    }


    $hamm_res = [];
    foreach ($tfidf_data as $index => $data) {
        if ($index == 4) break;
        $hamm_res[] = hammDist($data, $tfidf_data[4]);
    }

    $last_idx = count($similarity_data) - 1;
    $result_dice = [];
    foreach ($tfidf_data as $index => $data) {
        $numerator = 0.0;
        $denom_wkq = 0.0;
        $denom_wkj = 0.0;

        for ($i = 0; $i < 10; $i++) {
            $numerator += $tfidf_data[$last_idx][$i] * $tfidf_data[$index][$i];
            $denom_wkq += pow($tfidf_data[$last_idx][$i], 2);
            $denom_wkj += pow($tfidf_data[$index][$i], 2);
        }

        if ((0.5 * $denom_wkq + 0.5 * $denom_wkj) != 0) {
            $result_dice[] = $numerator / (0.5 * $denom_wkq + 0.5 * $denom_wkj);
        } else $result_dice[] = 0;
    }

    $result_jaccard = [];
    foreach ($tfidf_data as $index => $data) {
        if ($index == $last_idx) break;
        $numerator = 0.0;
        $denom_wkq = 0.0;
        $denom_wkj = 0.0;

        for ($i = 0; $i < 10; $i++) {
            $numerator += $tfidf_data[$last_idx][$i] * $tfidf_data[$index][$i];
            $denom_wkq += pow($tfidf_data[$last_idx][$i], 2);
            $denom_wkj += pow($tfidf_data[$index][$i], 2);
        }

        if (($denom_wkq + $denom_wkj - $numerator) != 0) $result_jaccard[] = $numerator / ($denom_wkq + $denom_wkj - $numerator);
        else $result_jaccard[] = 0;
    }

    $result_overlap = [];
    foreach ($tfidf_data as $index => $data) {
        if ($index == $last_idx) break;
        $numerator = 0.0;
        $denom_wkq = 0.0;
        $denom_wkj = 0.0;
        $denom = 0.0;

        for ($i = 0; $i < 10; $i++) {
            $numerator += $tfidf_data[$last_idx][$i] * $tfidf_data[$index][$i];
            $denom_wkq += pow($tfidf_data[$last_idx][$i], 2);
            $denom_wkj += pow($tfidf_data[$index][$i], 2);
        }

        $denom = min($denom_wkq, $denom_wkj);

        $result_overlap[] = $numerator / $denom;
    }

    $result_cosine = [];
    foreach ($tfidf_data as $index => $data) {
        if ($index == $last_idx) break;
        $numerator = 0.0;
        $denom_wkq = 0.0;
        $denom_wkj = 0.0;

        for ($i = 0; $i < 10; $i++) {
            $numerator += $tfidf_data[$last_idx][$i] * $tfidf_data[$index][$i];
            $denom_wkq += pow($tfidf_data[$last_idx][$i], 2);
            $denom_wkj += pow($tfidf_data[$index][$i], 2);
        }

        $result_cosine[] = $numerator / (sqrt($denom_wkq) +  sqrt($denom_wkj));
    }


    // print_r($similarity_data);
    // echo count($similarity_data);

    ?>

    <h2>Similarity</h2>
    <table border="1">
        <th>Q</th>
        <?php foreach ($vocab as $index => $term) : ?>
            <th align="center"><?= $term ?></th>
        <?php endforeach; ?>

        <?php foreach ($similarity_data as $index => $isi) : ?>
            <?php if ($index == count($similarity_data)) : ?>
                <tr>
                <tr>
                    <td>Q</td>
                <?php else : ?>
                <tr>
                    <td><?= $index; ?></td>
                <?php endif; ?>

                <?php foreach ($isi as $item) : ?>
                    <td><?php echo round($item, 1); ?></td>
                <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
    </table>

    <h2>Tf-Idf</h2>
    <table border="1">
        <th>Q</th>
        <?php foreach ($vocab as $index => $term) : ?>
            <th align="center"><?= $term ?></th>
        <?php endforeach; ?>

        <?php foreach ($tfidf_data as $index => $isi) : ?>
            <?php if ($index == count($tfidf_data)) : ?>
                <tr>
                <tr>
                    <td>Q</td>
                <?php else : ?>
                <tr>
                    <td><?= $index; ?></td>
                <?php endif; ?>

                <?php foreach ($isi as $item) : ?>
                    <td><?php echo round($item, 1); ?></td>
                <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
    </table>

    <h2>Dice</h2>
    <ul>
        <?php foreach ($result_dice as $index => $data) : ?>
            <li><?php echo "D" . ($index + 1) . " dan Q = " . round($data, 2); ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Jaccard</h2>
    <ul>
        <?php foreach ($result_jaccard as $index => $data) : ?>
            <li><?php echo "D" . ($index + 1) . " dan Q = " . round($data, 2); ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Overlap</h2>
    <ul>
        <?php foreach ($result_overlap as $index => $data) : ?>
            <li><?php echo "D" . ($index + 1) . " dan Q = " . round($data, 2); ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Cosine</h2>
    <ul>
        <?php foreach ($result_cosine as $index => $data) : ?>
            <li><?php echo "D" . ($index + 1) . " dan Q = " . round($data, 2); ?></li>
        <?php endforeach; ?>
    </ul>


    <h2>Euclidean</h2>
    <ul>
        <?php foreach ($euclidean_res as $result) : ?>
            <li><?= round($result, 2) ?></li>
        <?php endforeach; ?>
    </ul>



    <h2>Manhattan</h2>
    <ul>
        <?php foreach ($manhattan_res as $result) : ?>
            <li><?= round($result, 2) ?></li>
        <?php endforeach; ?>
    </ul>



    <h2>Minkowski</h2>
    <ul>
        <?php foreach ($minkowski_res as $result) : ?>
            <li><?= round($result, 2) ?></li>
        <?php endforeach; ?>
    </ul>



    <h2>Chebyshev</h2>
    <ul>
        <?php foreach ($chebyshev_res as $result) : ?>
            <li><?= round($result, 2) ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Canberra</h2>
    <ul>
        <?php foreach ($canberra_res as $result) : ?>
            <li><?= round($result, 2) ?></li>
        <?php endforeach; ?>
    </ul>


    <h2>Hamming</h2>
    <ul>
        <?php foreach ($hamm_res as $result) : ?>
            <li><?= $result; ?></li>
        <?php endforeach; ?>
    </ul>


</body>

</html>