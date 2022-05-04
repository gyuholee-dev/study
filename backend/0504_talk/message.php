<table>
    <?php
        $conn = mysqli_connect('localhost', 'root', '', 'testdb');
        $sql = "SELECT * FROM messages";
        $res = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>".$row["username"].":</td>";
            echo "<td>".$row["message"]."</td>";
            echo "</tr>";
        }
    ?>
</table>