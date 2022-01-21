<?php
echo "(1) 다음에서 'P' 자가 몇개인가?<br>";
echo "(1) 다음에서 'HP' 자가 몇개인가?<br>";
$str = "PHP & HTML";
function countStr($str, $search)
{
    $cnt = 0;
    $len = strlen($str);
    $slen = strlen($search);
    for ($i=0; $i < $len; $i++) {
        $t = substr($str, $i, $slen);
        if ($t == $search) {
            $cnt = $cnt + 1;
        }
    }
    return $cnt; 
}
echo '문자열: '.$str.'<br>';
echo 'P 답: '.countStr($str, 'P').'개<br>';
echo 'HP 답: '.countStr($str, 'HP').'개<br>';

echo '<br>';
echo "(2) php 를 php.ver7 로 교체<br>";
$str = "php & html";
echo '문자열: '.$str.'<br>';
echo '답: '.str_replace('php', 'php.ver7', $str);
