<?php
include_once('simple_html_dom.php');

$opts = array(
    'http' => array(
        'method' => "GET",
        'header' => "Accept-language: en\r\n" .
            "User-Agent:    Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6\r\n" .
            "Cookie: foo=bar\r\n"
    )
);
$context = stream_context_create($opts);
$url = "https://dl.acm.org/doi/abs/10.1145/3332184";

$html = file_get_html($url, false, $context);

foreach ($html->find('p') as $index => $j) {
    # code...
    echo $j  . ' count :  ' . strlen($j) . '<br>';
    echo "<br>";
    echo str_word_count($j);
    // COUNT 1407
    // WORD COUNT 202
}
