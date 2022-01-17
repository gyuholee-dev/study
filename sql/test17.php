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

echo '(3) 구구단을 출력하시오<br>';
function gugudan($first) {
    echo '구구단 '.$first.'단<br>';
    for ($i=1; $i<=9 ; $i++) {
        $result = $first*$i;
        echo $first.' x '.$i.' = '.$result.'<br>';
    }
    echo '<br>';
}
for ($i=1; $i <= 9 ; $i++) { 
    gugudan($i);
}


