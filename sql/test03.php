<?php
    include 'include/head.inc';
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <style>
        /* table {
            border-collapse: collapse;
        } */
        th, td {
            text-align: center;
            padding: 3px;
        }
    </style>
</head>
<!-- 20220104 -->
<center>
<font face="맑은 고딕">

<h3>HTML 에서 Table Tag</h3>
<hr color="orange">

<br>
<table cellpadding=3 cellspacing=0 border=1>
    <tr>
        <!-- <th width=60 align=center bgcolor=lightblue>사번</th> -->
        <th rowspan=2 width=60 align=center bgcolor=lightblue>사번</th>
        <!-- <th width=90 align=center bgcolor=lightblue>성명</th> -->
        <!-- <th width=60 align=center bgcolor=lightblue>성별</th> -->
        <th colspan=2 width=150 align=center bgcolor=lightblue>성명, 성별</th>
        <th width=120 align=center bgcolor=lightblue>전화번호</th>
        <th width=60 align=center bgcolor=lightblue>구분</th>
    </tr>
    <tr>
        <!-- <td align=center>1111</td> -->
        <td align=center>도영해</td>
        <td align=center>남자</td>
        <td align=center>010-3012-6134</td>
        <td align=center>정규</td>
    </tr>
</table>

<br>
<!-- 20220105 -->
<table cellpadding=3 cellspacing=0 border=1>
    <tr>
        <th width=100>내용</th>
        <th width=70>성명</th>
        <th width=60>성별</th>
        <th width=90>팀구분</th>
    </tr>
    <tr>
        <td>테스트-1</td>
        <td>홍길동</td>
        <td>남자</td>
        <td>1팀</td>
    </tr>
    <tr>
        <td rowspan=2>테스트-2</td>
        <td>김선영</td>
        <td>여자</td>
        <td>2팀</td>
    </tr>
    <tr>
        <!-- <td></td> -->
        <td>최동수</td>
        <td>남자</td>
        <td>2팀</td>
    </tr>
</table>

</center>
</html>