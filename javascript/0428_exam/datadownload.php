<?php

function saveJson($file, $json) {
    $json = json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return file_put_contents($file, $json);
}

function filter_filename($name) {
    // remove illegal file system characters https://en.wikipedia.org/wiki/Filename#Reserved_characters_and_words
    $name = str_replace(array_merge(
        array_map('chr', range(0, 31)),
        array('<', '>', ':', '"', '/', '\\', '|', '?', '*')
    ), '', $name);
    $name = preg_replace('/\s+/', '_', $name);
    // maximise filename length to 255 bytes http://serverfault.com/a/9548/44086
    $ext = pathinfo($name, PATHINFO_EXTENSION);
    $name= mb_strcut(pathinfo($name, PATHINFO_FILENAME), 0, 255 - ($ext ? strlen($ext) + 1 : 0), mb_detect_encoding($name)) . ($ext ? '.' . $ext : '');
    return $name;
}


// phpinfo();
$json = file_get_contents('data/drama.json');
$data = json_decode($json, true);

$fileList = array();
foreach ($data as $category => $cat) {
    $files = array();
    @mkdir("./files/$category");
    foreach ($cat as $name => $url) {
        if(strpos($name,'^') !== false){
            $name = explode('^',$name)[0];
        }
        $fileExt = pathinfo($url, PATHINFO_EXTENSION);
        $filename = $name.'.'.$fileExt;
        $filename = filter_filename($filename);
        $target = "./files/$category/$filename";
        $files[$name] = $filename;

        if (file_exists($target)) {
            echo $filename.' already exists<br>';
            continue;
        }
        if (file_put_contents($target, file_get_contents($url))) {
            echo "$filename Downloaded<br>";
        } else {
            echo "$filename Download Failed<br>";
        }
    }
    $fileList[$category] = $files;
}
saveJson('./files/filelist.json', $fileList);


