<?php
// Functions

function console_log($log)
{
  if (is_array($log)) {
    $log = json_encode($log);
    $script = "
        <script id='backendLog'>
           var log = JSON.parse('$log');
           console.log(log);
           backendLog.remove();
        </script>
    ";
  } else {
    $log = preg_replace('/\s+/', ' ', $log);
    $log = addslashes($log);
    $script = "
        <script id='backendLog'>
           var log = '$log';
           console.log(log);
           backendLog.remove();
        </script>
    ";
  }

  echo $script;
}

function sendMsg($msg, $url) {
  echo "
    <script>
      alert('$msg');
      location.href='$url';
    </script>
  ";
}

function tableExist($table) {
  global $db;
  $sql = "SHOW TABLES LIKE '$table'";
  $res = mysqli_query($db, $sql);
  if (mysqli_num_rows($res) != 0) {
    return true;
  }
  return false;
}

function getAllRecords($table, $pkey=true) {
  global $db;
  $records = array();
  $sql = "SELECT * FROM $table";
  $res = mysqli_query($db, $sql);
  $i = 0;
  while ($a = mysqli_fetch_row($res)) {
    if ($pkey == true) {
      $records[$a[0]] = array();
      foreach ($a as $key => $value) {
        $records[$a[0]][$key] = $value;
      }
    } elseif ($pkey == false) {
      $records[$i] = array();
      foreach ($a as $key => $value) {
        $records[$i][$key] = $value;
      }
      $i++;
    }
  }
  return $records;
}

function getCountRecords($table) {
  global $db;
  $sql = "SELECT COUNT(*) FROM $table";
  $res = mysqli_query($db, $sql);
  $a = mysqli_fetch_row($res);
  return $a[0];
}

function getThisFile() {
  if(strpos($_SERVER['REQUEST_URI'], '?') !== false) {  
    $urls = explode('?', $_SERVER['REQUEST_URI']);
    $urls = $urls[0];
  } else {
    $urls = $_SERVER['REQUEST_URI'];
  }
  $urls = array_reverse(explode('/', $urls));
  $thisFile = trim($urls[0]);
  return $thisFile;
}

function getURLParam($except=false, $insert=false) {
  $urls = '';
  $reqUrl = $_SERVER['REQUEST_URI'];
  if (strpos($reqUrl, '?') !== false) {  
    $urls = explode('?', $reqUrl);
    $urls = $urls[1];
    $urls = explode('&', $urls);

    if ($except !== false) {
      if (is_array($except) === false) {
        $except = [$except];
      }
      foreach ($except as $k => $eval) {
        foreach ($urls as $key => $value) {
          if (strpos($value, $eval.'=') !== false) {
            unset($urls[$key]);
          }
        }
      }
    }
    foreach ($urls as $key => $value) {
      if (explode('=', $value)[1] == '') {
        unset($urls[$key]);
      }
    }
    $urls = implode('&', $urls);
  }
  
  if ($insert !== false) {
    if ($urls !== '') {
      $urls = $insert.'&'.$urls;
    } else {
      $urls = $insert;
    }
  }

  if ($urls !== '') {
    return '?'.$urls;
  } else {
     return ''; 
  }
}

function isDate($str) {
	$d = date('Y-m-d', strtotime($str));
	return $d == $str;
}


function numStr($numb, $numSize) {
  $add = '0';
  for ($i=0; $i < $numSize; $i++) { 
    $add = $add.'0';
  }
  $numb = $add.(string)$numb;
  $numb = substr($numb, 0-$numSize);
  return $numb;
}