<?php
require_once 'includes/global.php';
require_once 'includes/functions.php';


$tableList = [
  'salefrut' => '',
  'custlist' => '',
  'dealammt' => '',
  'salelist' => '',
];

// 테이블 존재 검사
foreach ($tableList as $key => $table) {
  if (!tableExist($key)) {
    $tableList[$key] = "
      <a href='apps/$key/create.php'>
        테이블 생성
      </a>
    ";
  }
}
// print_r($tableList);



?>
<!-- html -->
<!DOCTYPE html>
<html lang="ko">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="styles/style.css">
</head>
<body>
<h2 class="title">데이터 목록</h2>
<!-- contents -->
<style>
  .container {
    display: flex;
    flex-direction: column;
    width: 100%;
    height: 100%;
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
    /* justify-content: center; */
    overflow: hidden;
  }
  .list:first-child {
    margin-left: 20px;
  }
  .list:last-child {
    margin-right: 20px;
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
  }
  .list .content {
    display: flex;
    width: 100%;
    height: 100%;
    flex-direction: column;
    justify-content: center;
  }

</style>


<div class="container">

  <div class="inner">
    <div class="list">
      <div class="header">
        <span class="title">제일청과</span>
        <span>더보기</span>
      </div>
      <div class="content"><?=$tableList['salefrut']?></div>
    </div>
    <div class="list">
      <div class="header">
        <span class="title">한국유통</span>
        <span>더보기</span>
      </div>
      <div class="content"><?=$tableList['custlist']?></div>
    </div>
  </div>

  <div class="inner">
    <div class="list">
      <div class="header">
        <span class="title">효성상사</span>
        <span>더보기</span>
      </div>
      <div class="content"><?=$tableList['dealammt']?></div>
    </div>
    <div class="list">
      <div class="header">
        <span class="title">판매현황</span>
        <span>더보기</span>
      </div>
      <div class="content"><?=$tableList['salelist']?></div>
    </div>
  </div>

</div>



<!-- contents -->
</body>
</html>
