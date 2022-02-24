<div class="tbContents">
  <strong class="red" style="font-size:125%">
    <?=$tableName?> 테이블을 생성하겠습니까?
  </strong>
  <br>
  <br>
  <form method="post">
    <input type="hidden" name="do" value="create">
    <input type="submit" class="active" name="submit" value="Yes">
    <input type="button" value="No"
      onclick="location.href='start.php'">
  </form>
</div>