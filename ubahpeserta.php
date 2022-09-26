<?php
    $conn = new mysqli("localhost","root","","fsputspro");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Peserta</title>
    <style>
        table,tr,td,th{
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <a href="index.php">Balik</a>
    <table>
        <tr>
            <th>Peserta</th>
            <?php 
                $sql = "SELECT * FROM matakuliah";
                $res = $conn->query($sql);

                while ($row = $res->fetch_assoc()){
                    echo "<th>".$row['kode']."-".$row['nama']."</th>";
                }
                
            ?>
        </tr>
        <?php 
            $sql1 = "SELECT * FROM mahasiswa";
            $res1 = $conn->query($sql1);

            while ($row1 = $res1->fetch_assoc()){
                echo "<tr><td>".$row1['nrp']."-".$row1['nama']."</td>";
                for($i=1; $i<=$res->num_rows;$i++){
                    echo "<td><input type='txt$i'></td>";
                }
            }
        ?>
    </table>
</body>
</html>