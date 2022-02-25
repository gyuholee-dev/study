
<?php

$sql = "SELECT * FROM cousmast ";
$res = mysqli_query($db, $sql);

$inputTemplate = [
  "<td><input name='couscode[]' value='<value-couscode>' type='text' style='width:36px;' readonly></td>",
  "<td><input name='cousname[]' value='<value-cousname>' type='text' maxlength='30'></td>",
  "<td><input name='cousfrom[]' value='<value-cousfrom>' type='date'></td>",
  "<td><input name='coustoto[]' value='<value-coustoto>' type='date'></td>",
  "<td><input name='cousdays[]' value='<value-cousdays>' type='number' style='width:80px;'></td>",
  "<td><input name='coustime[]' value='<value-coustime>' type='number' style='width:80px;'></td>",
  "<td><input name='noperson[]' value='<value-noperson>' type='number' style='width:60px;'></td",
];
foreach ($inputTemplate as $key => $value) {
  $inputTemplate[$key] = addslashes($value);
}

$inputTemplate = json_encode($inputTemplate);
echo $inputTemplate;
// echo "<script>var inputTemplate = JSON.parse(String('$inputTemplate')); </script>";

?>

<script>
  console.log(inputTemplate);
  function expandRow() {
    lastNumb = lastNumb+1;
    var target = document.getElementById('tr_end');
    var html = '';
    
    const template = document.createElement('template');
    template.innerHTML = html;
    document.getElementById('maintable').childNodes[1]
      .insertBefore(template.content.firstChild, target);
    cnt = cnt+1;
  }

  function deleteRow() {
    var parent = document.getElementById('maintable').childNodes[1];
    var count = parent.childElementCount;
    if (parent.childNodes[count].className == 'unused') {
      return false;
    } else {
      parent.childNodes[count].remove();
    }
  }
</script>


<?php


echo "<div class='tbContents' style='padding: 15px 0'>";
echo ($do == 'manage')?"<form method='post'>":"";
echo "<table id='maintable' class='main $do' cellpadding='3' cellspacing='0'>";

if ($table == 'cousmast') {

  $edit = '';
  if ($do == 'manage') {
    $edit = "<th>삭제</th>";
  }

  echo "
    <tr>
      <th>코드</th>
      <th>과정명</th>
      <th>시작일자</th>
      <th>종료일자</th>
      <th>훈련일수</th>
      <th>훈련시간</th>
      <th>정원</th>
      $edit
    </tr>
  ";
  
  $cnt = 0;
  $lastNumb = 11;
  while($data =mysqli_fetch_assoc($res)) {
    $couscode = $data['couscode'];
    $cousname = $data['cousname'];
    $cousfrom = $data['cousfrom'];
    $coustoto = $data['coustoto'];
    $cousdays = $data['cousdays'];
    $coustime = $data['coustime'];
    $noperson = $data['noperson'];
    $edit = '';
    if ($do == 'manage') {
      $couscode = "
        <input name='couscode[]' value='$couscode'
          type='text' style='width:36px;' readonly>
      ";
      $cousname = "
        <input name='cousname[]' value='$cousname'
          type='text' maxlength='30'>
      ";
      $cousfrom = "
        <input name='cousfrom[]' value='$cousfrom'
          type='date'>
      ";
      $coustoto = "
        <input name='coustoto[]' value='$coustoto'
          type='date'>
      ";
      $cousdays = "
        <input name='cousdays[]' value='$cousdays'
          type='number' style='width:80px;'>
      ";
      $coustime = "
        <input name='coustime[]' value='$coustime'
          type='number' style='width:80px;'>
      ";
      $noperson = "
        <input name='noperson[]' value='$noperson'
          type='number' style='width:60px;'>
      ";


      $edit = "<td>삭제</td>";
    }
    echo "
      <tr>
        <td>$couscode</td>
        <td>$cousname</td>
        <td>$cousfrom</td>
        <td>$coustoto</td>
        <td>$cousdays</td>
        <td>$coustime</td>
        <td>$noperson</td>
        $edit
      </tr>
    ";

    $cnt++;
    $lastNumb = $data['couscode'];
  }
  echo "
    <tr id='tr_end'></tr>
    <tr id='expand'>
    <td><a href='#tr_end' onclick='expandRow()'>추가</a></td>
    <td colspan='6'></td>
    <td>
      <script>var lastNumb=$lastNumb; var cnt=$cnt;</script>
      <a href='#tr_end' onclick='deleteRow()'>삭제</a>
    </td>
    </tr>
  ";

  
}

echo "</table>";

echo ($do == 'manage')?"</form>":"";
echo "</div>";

?>