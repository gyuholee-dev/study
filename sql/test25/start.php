<?php
require_once 'includes/global.php';

// $title = $tableName.' 관리';

?>
<!-- html -->
<?php
    include 'includes/_header.php';
?>
<h3>장난감 대여 관리</h3>
<hr>

<div class="tbContents">
<table class="headers" cellpadding="3" cellspacing="0" border="1">
    <tr>
        <th width="120">장난감관리</th>
        <th width="120">고객관리</th>
        <th width="120">대여반납</th>
        <th width="120">자료조회</th>
    </tr>
    <tr>
        <td>
            <input type="button" value="생성" 
            onclick="location.href='toyy_create.php'">
        </td>
        <td>
            <input type="button" value="생성" 
            onclick="location.href='cust_create.php'">
        </td>
        <td>
            <input type="button" value="대여등록" 
            onclick="location.href='rent_start.php'">
        </td>
        <td>
            <input type="button" value="장난감별 수익" 
            onclick="location.href='view_1.php'">
        </td>
    </tr>
    <tr>
        <td>
            <input type="button" value="입력" 
            onclick="location.href='toyy_insert.php'">
        </td>
        <td>
            <input type="button" value="입력" 
            onclick="location.href='cust_insert.php'">
        </td>
        <td>
            <input type="button" value="대여취소" 
            onclick="location.href='rent_cancel.php'">
        </td>
        <td>
            <input type="button" value="조회-2" 
            onclick="location.href='view_2.php'">
        </td>
    </tr>
    <tr>
        <td>
            <input type="button" value="조회" 
            onclick="location.href='toyy_select.php'">
        </td>
        <td>
            <input type="button" value="조회" 
            onclick="location.href='cust_select.php'">
        </td>
        <td>
            <input type="button" value="반납등록" 
            onclick="location.href='rent_end.php'">
        </td>
        <td>
            <input type="button" value="조회-3" 
            onclick="location.href='view_3.php'">
        </td>
    </tr>
    <tr>
        <td>
            <input type="button" value="편집" 
            onclick="location.href='toyy_edit.php'">
        </td>
        <td>
            <input type="button" value="편집" 
            onclick="location.href='cust_edit.php'">
        </td>
        <td>
            <input type="button" value="반납취소" 
            onclick="location.href='rent_return.php'">
        </td>
        <td>
            <input type="button" value="조회-4" 
            onclick="location.href='view_4.php'">
        </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td>
            <input type="button" value="생성"
            onclick="location.href='rent_create.php'">
        </td>
        <td></td>
    </tr>

</table>
</div>



<?php
    // include $id.'includes/_menu.php';
?> 
<?php
    include 'includes/_footer.php';
?>