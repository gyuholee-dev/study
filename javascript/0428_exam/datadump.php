<?php
$json = file_get_contents('data/drama.json');
$data = json_decode($json, true);

function shuffle_assoc(&$array) {
    $keys = array_keys($array);
    shuffle($keys);
    foreach($keys as $key) {
        $new[$key] = $array[$key];
    }
    $array = $new;
    return true;
}

foreach ($data as $key => $cat) {
    shuffle_assoc($cat);
    echo '<pre>';
    echo '$'.$key.'= array(<br>';
    foreach ($cat as $k => $value) {
        echo '  "'.$k.'" => "'.$value.'",<br>';
    }
    echo ');';
    echo '</pre>';
}
