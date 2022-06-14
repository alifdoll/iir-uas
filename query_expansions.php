<?php

use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Tokenization\WhitespaceTokenizer;
use StopWords\StopWords;

require_once __DIR__ . '/vendor/autoload.php';

function getQueryExpansions($query, array $terms)
{
    foreach ($terms as $index => $d) {
        $lowered = strtolower($d['title']);
        $stop_words_remover = new StopWords('en');
        $stopped = $stop_words_remover->clean($lowered);
        $terms[$index] = $stopped;
    }



    $tf = new TokenCountVectorizer(new WhitespaceTokenizer());
    $tf->fit($terms);
    $tf->transform($terms);


    $vocab = $tf->getVocabulary();

    $data_new = [];

    foreach ($vocab as $i => $vc) {
        $data_new[$vc] = array_sum(array_column($terms, $i));
    }

    arsort($data_new);

    $expansion_term = [];
    foreach ($data_new as $key => $d) {
        $expansion_term[] = $key;
    }


    if (count($expansion_term) > 1) {
        $expansion_term = array_slice($expansion_term, 0, 4);
    }

    $expansions = [];

    foreach ($expansion_term as $term) {
        if ($term == $query) continue;
        $query = trimQuery($query);
        $expansions[] = $query . " " . $term;
    }

    return $expansions;
}

function trimQuery($query)
{
    $count = explode(" ", $query);
    if (count($count) > 3) {
        $query = $count[0] . " " . $count[1] . " " . $count[2];
    }
    return $query;
}
