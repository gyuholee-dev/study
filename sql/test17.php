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
    if ($key == 0) echo '합계: ';
    echo $value;
    $total = $total+$value;
    if ($key != $count-1) echo ' + ';
    elseif ($key == $count-1) echo ' = '.$total;
}