<?php
/*
//// 쿠키 (COOKEY) - 과자
// https://www.php.net/manual/en/function.setcookie.php

// 유닉스 타임스탬프 (1970년1월1일 부터 흐른시간 초단위)
$what = time();
echo $what;
// 쿠키 지속시간
time() + 24*60*60*365; // 현재시간으로부터 1년간, 초단위;
// 1년: 31536000
// 30일: 2592000
// 7일: 604800
// 1일: 86400
// 1시간: 3600

// 쿠키 만들기
setcookie($name, $value, $expire, $path);
setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
setcookie($name, $value, $option=array());
// 쿠키 읽기
$_COOKIE['name'];
*/


// 테스트
// setcookie('test', '내용아무거나', time()+15);
// $cont = $_COOKIE['test'];
// echo '쿠키내용: '.$cont;


$cookieName = 'TestCookie';
$cookieValue = 'Information';
if (isset($_COOKIE[$cookieName])) {
    echo '쿠키 존재<br>';
    echo '쿠키 내용: '.$_COOKIE[$cookieName];
} else {
    echo '쿠키 만듦';
    setcookie($cookieName, $cookieValue, time()+10, '/sql');
}

$cookieName = 'TestCookie';
$cookieValue = 'Information';
if (isset($_COOKIE[$cookieName])) {
    echo '쿠키 존재<br>';
    echo '쿠키 내용: '.$_COOKIE[$cookieName];
} else {
    echo '쿠키 만듦';
    setcookie($cookieName, $cookieValue, time()+10, '/sql');
}
