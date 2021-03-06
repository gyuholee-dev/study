<?php
require_once 'includes/global.php';
require_once 'includes/functions.php';


$tableList = [
  'salefrut' => [
    'title' => '제일청과'
  ],
  'custlist' => [
    'title' => '한국유통'
  ],
  'dealamnt' => [
    'title' => '효성상사'
  ],
  'salelist' => [
    'title' => '거래처'
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
<style type="text/css">
  .container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    max-width: 960px;
    height: 100%;
    margin-left: auto;
    margin-right: auto;
  }
  .inner {
    display: flex;
    flex-direction: row;
    justify-content: center;
    width: 100%;
    margin-bottom: 10px;
  }
  .list {
    display: flex;
    width: 400px;
    height: 200px;
    background-color: white;
    margin: 10px;
    border-radius: 10px;
    flex-direction: column;
    overflow: hidden;
  }

  .list span {
    align-self: center;
  }

  .list .header {
    display: flex;
    height: 36px;
    background-color: #7df3ff;
    justify-content: space-between;
    padding: 5px 10px;
  }
  .list .header .title {
    font-size: 120%;
    font-weight: bold;
    text-align: left;
    margin-left: 5px;
  }
  .list .content {
    display: flex;
    width: 100%;
    height: 100%;
    flex-direction: column;
    justify-content: center;
  }

  table.sum {
    width: 400px;
  }
  table.sum td {
    padding: 5px 10px;
    white-space: nowrap;
    overflow: hidden;
    max-width: 60px;
    text-overflow: ellipsis;
  }

</style>
</head>
<body>
<h2 class="title">데이터 목록</h2>
<!-- contents -->

<div class="container">
  <?php
    foreach ($tableList as $key => $data) {
      $title = $data['title'];
      $link = '';
      $summary = '';

      if ($data['exist'] == true) {
        $link = "<a href='apps/$key/view.php'>더보기 ></a>";
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
            <span class='title'>$title</span>
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
