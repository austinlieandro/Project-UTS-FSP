<?php
    require_once("class/mahasiswa.php");
    require_once("class/peserta.php");

    $mahasiswa = new Mahasiswa("localhost","root","","fsputspro");
    $peserta = new Peserta("localhost","root","","fsputspro");
    $conn = new mysqli("localhost","root","","fsputspro");
    if(isset($_GET["btnSimpan"])){
        //echo $_GET["kode"];
        $arrPeserta = array();

        foreach($_GET as $key => $val){
            if (is_numeric($val) && (($val != null) || ($val != ""))){
                $arr_nrp_kode = explode("-",$key);
                $nrp1 = $arr_nrp_kode[0];
                $kode1 = $arr_nrp_kode[1];

                array_push($arrPeserta,array($kode1,$nrp1,$val));
            }
        }
        foreach($arrPeserta as $p){
            // if(!is_numeric($p[2])){
            //     $sql = "DELETE FROM peserta WHERE nrp = ? AND kode = ?";
            //     $stmt = $conn->prepare($sql);
            //     $stmt->bind_param("ss", $p[1],$p[0]);
            //     $stmt->execute();
            // }
            $res = $peserta->CekNilai($p[1],$p[0]);
            // $num_row = $res->num_rows;
            echo $res;
            //echo "<br><br>";
            if(is_numeric($p[2])){
                if($num_row > 0){
                    $sql = "UPDATE peserta SET nilai = ? WHERE kode = ? AND nrp = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("dss",$p[2],$p[0],$p[1]);
                    $stmt->execute();
                }
                $sql = "INSERT INTO peserta VALUES (?,?,?)";
                $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssd",$p[0],$p[1],$p[2]);
                    $stmt->execute();
            }
            
        }
        print_r($arrPeserta);
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
                $mh = new mahasiswa("localhost","root","","fsputspro");
                $res1 = $mh->GetMahasiswa();

                $sql = "SELECT kode FROM matakuliah";
                $res = $conn->query($sql);
                $arrKode = array();

                while ($row = $res->fetch_assoc()){
                    $kodeMk = $row['kode'];
                    $arrKode[] = $kodeMk;
                }
    
                while ($row1 = $res1->fetch_assoc()){
                    $nrp = $row1['nrp'];
                    $data = 0;
                    $current = 0;

                    echo "<tr><td>".$row1['nrp']."-".$row1['nama']."</td>";
                    $sqll = "SELECT * FROM peserta WHERE nrp = $nrp";
                    $res = $conn->query($sqll);

                    $counter = 0;
                    while ($row = $res->fetch_assoc()) {
                        $kode = $row['kode'];
                        echo "<td><input type='number' value=".$row['nilai']." name='$nrp-$kode'></td>";
                        $data += 1;
                        $current = $data;
                    }
                    $range = 5 - $data;
                    for ($i=0; $i<$range; $i++){
                        $kode = $arrKode[$current];
                        echo "<td><input type='text' value='-' name='$nrp-$kode'></td>";
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