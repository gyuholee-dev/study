<div class="tbMenu">
  <script>
    function changeView() {
      var form = document.getElementById('tbmenu');
      form.submit();
    }
  </script>
  <table class="inner" width="100%">
    <tr>
      <td class="left">

        <form id="tbmenu" method="get" action="<?=$action.'.php'?>">
          <label>항목수 
            <input type="number" min="1" max="99" 
            name="items" value="<?=$items?>"
            style="width: 40px;" onchange="changeView()">
          </label>
          <?php
            $checked = ['', '', ''];
            if ($where == '') $checked[0] = 'checked';
            elseif ($where == '국내') $checked[1] = 'checked';
            elseif ($where == '해외') $checked[2] = 'checked';
          ?>
          <label style="margin-left:10px;">
            <input type="radio" name="where" 
            value="" onchange="changeView()" <?=$checked[0]?>>전체
          </label>
          <label>
            <input type="radio" name="where" 
            value="국내" onchange="changeView()" <?=$checked[1]?>>국내
          </label>
          <label>
            <input type="radio" name="where" 
            value="해외" onchange="changeView()" <?=$checked[2]?>>해외
          </label>
        </form>

      </td>
      <td class="right">
        <input type="button" value="초기화"
        onclick="location.href='<?=$action.'.php'?>'">
      </td>
    </tr>
  </table>
</div>