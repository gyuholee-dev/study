<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = mysqli_connect($host, $user, $pass);
    mysqli_select_db($db, "mydb");
    mysqli_report(MYSQLI_REPORT_OFF);

    function query($db, $query) {
        $header = false;
        echo '<table>';
        $res = mysqli_query($db, $query);
        while ($row = mysqli_fetch_assoc($res))
        {
            if ($header == false) {
                echo '<tr>';
                foreach($row as $key=>$value)
                {
                    echo '<td class="head">';
                    echo $key;
                    echo '</td>';
                }
                echo '</tr><tr>';
                foreach($row as $key=>$value)
                {
                    echo '<td>';
                    echo $value;
                    echo '</td>';
                }
                echo '</tr>';
                $header = true;
            } else {
                echo '<tr>';
                foreach($row as $key=>$value)
                {
                    echo '<td>';
                    echo $value;
                    echo '</td>';
                }
                echo '</tr>';
            }
        }
        echo '</table>';
    }

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <style>
        table {
            width: 100%;
            border: 1px solid #444444;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #444444;
            text-align: center;
            padding: 3px;
        }
        .head {
            background-color: #e5e5e5;
            font-weight: bold;
        }
        .textbox {
            /* width: 100%; */
            /* height: 120px; */
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .button (

        )
    </style>
</head>
<body>

    <?php
        // $sql = "SELECT * FROM milk";
        // query($db, $sql);

        // $q = 'SELECT * FROM milk';
        // if (isset($_GET['q'])) {
        //     $q = $_GET['q'];
        // }

        if (isset($_POST['q'])) {
            $q = $_POST['q'];
        
            echo 'Query: '. $q.'<br><br>';
            query($db, $q);
        }
    ?>

    <form method="post">
        <input type='text' name='q' class='textbox'>
        <input type='submit' value='입력' class='button'>
    </form>

</body>
</html>