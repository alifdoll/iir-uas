<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TESTING</title>
</head>



</html>
<?php
include_once('simple_html_dom.php');
error_reporting(E_ERROR | E_PARSE);
echo str_word_count("Norman Daniels");
echo "<br>";
echo "<br>";
echo "<br>";

try {

    $opts = array(
        'http' => array(
            'method' => "GET",
            'header' => "Accept-language: en\r\n" .
                "User-Agent:    Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6\r\n" .
                "Cookie: foo=bar\r\n"
        )
    );
    $context = stream_context_create($opts);

    // $url = "https://www.hindawi.com/journals/jece/2013/892628/"; // WORK

    // $url = "https://www.tandfonline.com/doi/abs/10.1162/152651601300168834"; //WORK

    // $url = "https://www.science.org/doi/abs/10.1126/scirobotics.aar7650"; NOT WORK

    $url = "https://ieeexplore.ieee.org/abstract/document/4141037/";

    $html = file_get_html($url, false, $context);

    foreach ($html->find('div') as $index => $j) {
        # code...
        $c = str_word_count($j);
        $t = strlen($j);
        if ($c > 100 && $c <= 300) {
            // var_dump($j->plaintext);
            // echo $j;
        }
        echo $j->plaintext;
        echo "<br>";
        echo ' count :  ' . str_word_count($j->plaintext);
        // echo "<br>";
        echo " length : " . strlen($j->plaintext);
        echo "<br>";
        echo "<br>";
        // COUNT 1407
        // WORD COUNT 202
    }

    // var_dump(str_word_count($html->find('p')[0]->plaintext) > 100);
} catch (Throwable $th) {

    echo $th;
    echo "<br>";
}
echo "<br>";
// echo "end";
