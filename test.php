<?php
include_once('simple_html_dom.php');
error_reporting(E_ERROR | E_PARSE);
echo "start";
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
    $url = "https://www.nature.com/articles/s41579-018-0118-9.";

    $html = file_get_html($url, false, $context);

    foreach ($html->find('p') as $index => $j) {
        # code...
        $c = str_word_count($j);
        if ($c > 200 && $c <= 300) {
            var_dump($j->plaintext);
        }
        // echo $j  . ' count :  ' . strlen($j) . '<br>';
        // echo "<br>";
        // echo str_word_count($j);
        // COUNT 1407
        // WORD COUNT 202
    }
} catch (Throwable $th) {

    echo "TEST THROW";
    echo "<br>";
}
echo "<br>";
echo "end";
