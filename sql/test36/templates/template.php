<!-- html -->
<!DOCTYPE html>
<html lang="ko">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="styles/style.css">
<link rel="stylesheet" href="styles/xeicon.min.css">
</head>
<body>
<style>
  
</style>

<div id="container" class="wrap column">
  <!-- topmenu -->
  <div id="topmenu">
    <span class="title">
      <i class='xi-list-dot'></i> <?=$title?>
    </span>
  </div>
  <!-- topmenu -->

  <div id="main" class="wrap row">
    <!-- sidemenu -->
    <!-- <div id="sidemenu">
    <? include 'templates/_sidemenu.php'; ?>
    </div> -->
    <!-- sidemenu -->

    <!-- contents -->
    <div id="contents">
    <? include $content; ?>
    </div>
    <!-- contents -->
  </div>

  <!-- bottommenu -->
  <!-- <div id="bottommenu">
  </div> -->
  <!-- bottommenu -->
</div>

</body>
</html>