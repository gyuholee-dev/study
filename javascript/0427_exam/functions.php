<?php // functions.php

// 파일 존재 검사
function fileExists($file)
{
    return file_exists($file);
}

// json 파일 오픈
function openJson($file)
{
    if (!fileExists($file)) {
        return false;
    }
    $json = file_get_contents($file);
    $json = json_decode($json, true);
    return $json;
}

// json 파일 세이브
function saveJson($file, $data)
{
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return file_put_contents($file, $json);
}

// 파일 로드
function loadFile($file)
{
    if (!fileExists($file)) {
        return false;
    }
    return file_get_contents($file);
}