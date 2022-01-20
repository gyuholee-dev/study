<?php
require 'include/global21.php';

$title = $tableName.' 관리';

if (tableExist($table) == false) {
    echo "<script>location.href='$id\_create.php';</script>";
}

?>
<!-- html -->
<?php
    include $id.'_header.php';
?>
<div class="tbContents">
    <table cellpadding=3 cellspacing=0 border=1>
        <tr>
            <td colspan="6" style="padding:0;">
                <table cellpadding=3 cellspacing=0 border=1>
                    <tr>
                        <th>사원번호</th>
                        <td></td>
                        <th>성명</th>
                        <td></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <th>사원번호</th>
            <th>가족관계</th>
            <th>성명</th>
            <th>나이</th>
            <th>직업</th>
            <th>동거여부</th>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>

    </table>
</div>
<?php
    include $id.'_footer.php';
?>