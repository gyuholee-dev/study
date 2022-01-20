<?php
echo '(1) 1에서 30까지 3의 배수만 합계?<br>';
$result = 0;
for ($i=1; $i<=30; $i++) {
    if ($i%3 == 0) {
        $result = $result + $i;
    }
}
echo '답: '.$result.'<br>';
echo '<br>';

echo '(2) 20 ~ 30 사이 4의 배수 갯수 및 합계?<br>';
$count = 0;
$result = 0;
for ($i=20; $i<=30 ; $i++) {
    if ($i%4 == 0) {
        $count = $count + 1;
        $result = $result + $i;
    }
}
echo '갯수: '.$count.'<br>';
echo '합계: '.$result.'<br>';
echo '<br>';

echo '(3) 구구단 9단을 출력하시오<br>';
function gugudan($first)
{
    echo '구구단 '.$first.'단<br>';
    for ($i=1; $i<=9 ; $i++) {
        $result = $first*$i;
        echo $first.' x '.$i.' = '.$result.'<br>';
    }
}
gugudan(9);
echo '<br>';

echo '(4) 200 ~300 에서 3배수이면서 4배수 갯수 및 합계<br>';
$count = 0;
$total = 0;
for ($i=200; $i <=300 ; $i++) {
    if ($i%3 == 0 && $i%4 == 0) {
        echo $i.', ';
        $count = $count + 1;
        $total = $total + $i;
    }
    if ($i == 300) {
        echo '<br>';
    }
}
echo '답: '.$count.' 합계: '.$total;
echo '<br><br>';

echo '(5) 2단에서 9단까지 구구단 출력<br>';
for ($i=2; $i <= 9 ; $i++) {
    gugudan($i);
    echo '----------------<br>';
}
echo '<br>';

echo '(5) 35, 8, 99, 20, 13 숫자에서 제일 큰 수와 제일 작은 수 및 합계 <br>';
$nums = array(35, 8, 99, 20, 13);
echo '최대: '.max($nums).'<br>';
echo '최소: '.min($nums).'<br>';
$count = count($nums);
$total = 0;
foreach ($nums as $key => $value) {
    if ($key == 0) {
        echo '합계: ';
    }
    echo $value;
    $total = $total+$value;
    if ($key != $count-1) {
        echo ' + ';
    } elseif ($key == $count-1) {
        echo ' = '.$total;
    }
}
echo '<br>';
echo '<br>';

echo '(7) (25 45) 임의의 2개 숫자 사이에 있는 짝수 갯수와 합, 홀수 갯수와 합 출력.<br>';
function cal7($startNum = false, $endNum = false)
{
    if ($startNum === false) {
        $startNum = rand(0, 98);
    }
    if ($endNum === false) {
        $endNum = rand($startNum, 99);
    }

    $evenCount = 0;
    $evenTotal = 0;
    $oddCount = 0;
    $oddTotal = 0;
    for ($i=$startNum; $i <= $endNum; $i++) {
        if ($i%2 == 0) {
            $evenCount = $evenCount + 1;
            $evenTotal = $evenTotal + $i;
        } else {
            $oddCount = $oddCount + 1;
            $oddTotal = $oddTotal + $i;
        }
    }
    echo $startNum.' ~ '.$endNum.'<br>';
    echo '짝수 갯수: '.$evenCount.'<br>';
    echo '짝수 합: '.$evenTotal.'<br>';
    echo '홀수 갯수: '.$oddCount.'<br>';
    echo '홀수 합: '.$oddTotal.'<br>';
}
// cal7();
cal7(25, 45);
echo '<br>';

echo '(8) 1글자씩 세로로 보여주기.<br>';
$str = "Insert into Educ(Numb,Date)";

// // 첫번째
// $str = preg_replace('/\s+/', '', $str);
// $res = str_split($str, 1);
// echo '문자열: '.$str.'<br>';
// foreach ($res as $key => $value) {
//     echo $value.'<br>';
// }

// 두번째
echo '문자열: '.$str.'<br>';
$ren = strlen($str);
for ($i=0; $i < $ren; $i++) {
    $s = substr($str, $i, 1);
    echo $s.'<br>';
}

echo '<br>';
echo '(9) 공백을 ? 로 바꾸기. t 를 X 로 바꾸기<br>';
echo '문자열: '.$str.'<br>';
echo '결과: '.str_replace(' ', '?', $str).'<br>';
echo '결과: '.str_replace('t', 'X', $str).'<br>';

echo '<br>';
echo '(10) $str 에서 "o" 문자 카운트해서 출력<br>';
echo '(10) $str 에서 "co" 문자 카운트해서 출력<br>';
$str = "naver.com, google.com, jungbo.co.kr";
echo '문자열: '.$str.'<br>';
// preg_match_all 활용
// echo 'o 결과: '.preg_match_all('/o/u',$str,$matches).'개<br>';
// echo 'co 결과: '.preg_match_all('/co/u',$str,$matches).'개<br>';
// strpos 활용
function countStr($str, $search)
{
    $count = 0;
    $ren = strlen($str);
    for ($i=0; $i < $ren; $i++) {
        if (strpos($str, $search, $i) !== false) {
            $count = $count + 1;
            $i = strpos($str, $search, $i);
        }
    }
    return $count;
}
// substr 활용
function countStr2($str, $search) {
    $count = 0;
    $ren = strlen($str);
    $sren = strlen($search);
    for ($i=0; $i < $ren; $i++) {
        if (substr($str, $i, $sren) == $search) {
            $count = $count + 1;
        }
    }
    return $count;
}
echo 'o 결과: '.countStr2($str, 'o').'개<br>';
echo 'co 결과: '.countStr2($str, 'co').'개<br>';

echo '<br>';
echo '(10) $str 에서 "com" 문자를 "co.kr" 로 바꿔서 $str 출력<br>';
echo '문자열: '.$str.'<br>';
// preg_replace 활용
// echo '결과: '.preg_replace('/com/u', 'co.kr', $str);
// str_replace 활용
echo '결과: '.str_replace('com', 'co.kr', $str);