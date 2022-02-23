<?php
require_once 'includes/global.php';
require_once 'includes/functions.php';


$tableList = [
  'insurance' => [
    'title' => '보험가입'
  ],
  'orderlist' => [
    'title' => '유기농식품'
  ],
  'membership' => [
    'title' => '체육센터'
  ],
  'shopping' => [
    'title' => '온라인쇼핑몰'
  ],
];

// 테이블 존재 검사
foreach ($tableList as $key => $table) {
  if (!tableExist($key)) {
    $tableList[$key]['exist'] = false;
  } else {
    $tableList[$key]['exist'] = true;
  }
}

?>
<!-- html -->
<!DOCTYPE html>
<html lang="ko">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="styles/style.css">
<link rel="stylesheet" href="styles/xeicon.min.css">
</head>
<body>
<h2 class="title"><i class='xi-list-dot'></i> 데이터 목록</h2>
<!-- contents -->

<div class="container">
  <?php
    foreach ($tableList as $key => $data) {
      $title = $data['title'];
      $link = '';
      $summary = '';

      if ($data['exist'] == true) {
        $link = "<a href='apps/$key/view.php'>더보기 <i class='xi-angle-right'></i></a>";
        $sql = "SELECT * FROM $key 
                ORDER BY 1 DESC 
                LIMIT 0, 5
                ";
        $res = mysqli_query($db, $sql);
        while ($a = mysqli_fetch_row($res)) {
          $summary .= '<tr>';
          foreach ($a as $k => $d) {
            if ($k == 0) continue;
            if ($k == 5) break;
            $summary .= "
              <td>$d</td>
            ";
          }
          $summary .= '</tr>';
        }
        $summary = "<table class='sum'>$summary</table>";

      } else {
        $summary = "
          <a href='apps/$key/create.php'>
            테이블 생성
          </a>
        ";
      }

      echo "
        <div class='list'>
          <div class='header'>
            <span class='title'><i class='xi-list-dot'></i> $title</span>
            <span>$link</span>
          </div>
          <div class='content'>
            $summary
          </div>
        </div>
      ";
    }
  ?>

</div>



<!-- contents -->
</body>
</html>
