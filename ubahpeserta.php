<?php
    $conn = new mysqli("localhost","root","","fsputspro");
    if(isset($_GET["btnSimpan"])){
        
    }
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
    <form action="#" method="get">
        <a href="index.php">Balik</a>
        <table>
            <tr>
                <th>Peserta</th>
                <?php 
                    $sql = "SELECT * FROM matakuliah";
                    //$sql2 = "select m.nama as 'nm_mh',m.nrp,mk.nama as 'nm_mk',mk.kode,p.nilai from mahasiswa m LEFT JOIN peserta p on m.nrp=p.nrp RIGHT JOIN matakuliah mk on mk.kode=p.kode";
                    $res = $conn->query($sql);
    
                    $namaMk = "";
                    $namaMh = "" ;
                    $jumMk = 0;
                    $jumMh = 0;
    
                    while ($row = $res->fetch_assoc()){
                        echo "<th>".$row['kode']."-".$row['nama']."</th>";
                        $namaMk = $row['nama'];
                        $jumMk += 1;
                    }
                ?>
            </tr>
            <?php 
                $sql1 = "SELECT * FROM mahasiswa";
                $res1 = $conn->query($sql1);
    
                while ($row1 = $res1->fetch_assoc()){
                    $nrp = $row1['nrp'];
                    $data = 0;
                    $current = 1;

                    echo "<tr><td>".$row1['nrp']."-".$row1['nama']."</td>";
                    $sql3 = "SELECT m.nama as 'nm_mh', p.kode as 'nm_mk', p.nilai FROM peserta p LEFT JOIN mahasiswa m ON p.nrp = m.nrp WHERE m.nrp = '$nrp'";
                    
                    //$sql4 = "SELECT mk.nama as 'nm_mk', m.nama as 'nm_mh', p.nilai FROM matakuliah mk LEFT JOIN peserta p ON p.kode = mk.kode LEFT JOIN mahasiswa m ON m.nrp = p.nrp";
    
                    $res2 = $conn->query($sql3);
    
                    while ($row2 = $res2->fetch_assoc()){
                        echo "<td><input type='txt' value=".$row2['nilai']." name='txt".$row1['nama']."-$current'></td>";
                        $data += 1;
                        $current = $data + 1;
                    }
                    $range = 5 - $data;
                    for ($i=0; $i<$range; $i++){
                        echo "<td><input type='txt' value='-' name='txt".$row1['nama']."-$current'></td>";
                        $current += 1;
                    }
                    $current = 1;
                    echo "</tr>";
                }
            ?>
        </table>
        <input type="submit" value="Simpan" name="btnSimpan" id="btnSimpan">
    </form>
</body>
</html>