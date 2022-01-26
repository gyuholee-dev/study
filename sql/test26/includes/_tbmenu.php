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
            <input type="number" min="1" max="99" name="items" value="<?=$items?>"
            style="width: 40px;" onchange="changeView()"></label>

        </form>

      </td>
      <td class="right">
        <input type="button" value="초기화"
        onclick="location.href='<?=$action.'.php'?>'">
      </td>
    </tr>
  </table>
</div>