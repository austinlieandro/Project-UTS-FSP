<?php
    require_once("class/mahasiswa.php");
    require_once("class/matakuliah.php");
    require_once("class/peserta.php");

    $mahasiswa = new Mahasiswa("localhost","root","","fsputspro");
    $matakuliah = new Matakuliah("localhost","root","","fsputspro");
    $peserta = new Peserta("localhost","root","","fsputspro");
    $conn = new mysqli("localhost","root","","fsputspro");
    
    if(isset($_GET["btnSimpan"])){
        $arrPeserta = array();

        foreach($_GET as $key => $val){
            if (is_numeric($val) || ($val == "")){
                $arr_nrp_kode = explode("-",$key);
                $nrp1 = $arr_nrp_kode[0];
                $kode1 = $arr_nrp_kode[1];

                array_push($arrPeserta,array($kode1,$nrp1,$val));
            }
        }
        print_r($arrPeserta);
        foreach($arrPeserta as $p){
            if(!is_numeric($p[2])){
                $peserta->ExecuteDML($p[0],$p[1],$p[2],"delete");
            }
            $sql = "SELECT nilai FROM peserta WHERE nrp ='".$p[1]."' and kode='".$p[0]."'";
            $res = $conn->query($sql);
            
            if ($row = $res->fetch_assoc()) {
                $data = 1;
            }
            else{
                $data = 0;
            }
            // $data = $peserta->CekNilai($p[1],$p[0]);
            if(is_numeric($p[2])){
                if($data > 0){
                    $peserta->ExecuteDML($p[0],$p[1],$p[2],"update");
                }
                $peserta->ExecuteDML($p[0],$p[1],$p[2],"insert");
            }
            
        }
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
                    $res = $matakuliah->GetMatakuliah();
    
                    $namaMk = "";
                    $namaMh = "" ;
                    $jumMk = 0;
    
                    while ($row = $res->fetch_assoc()){
                        $kode = $row['kode'];
                        $nama = $row['nama'];
                        echo "<th>".$row['kode']."-".$row['nama']."</th>";
                        $jumMk += 1;
                    }
                ?>
            </tr>
            <?php 
                $res1 = $mahasiswa->GetMahasiswa();
                $arrKode = $matakuliah->GetKodeMk();
                $arr_peserta = $peserta->GetPeserta();

                while ($row1 = $res1->fetch_assoc()){
                    $nrp = $row1['nrp'];
                    $data = 0;

                    echo "<tr><td>".$row1['nrp']."-".$row1['nama']."</td>";
                    
                    for($i=0; $i<count($arrKode); $i++){
                        foreach($arr_peserta as $value){
                            if($value[0] == $arrKode[$i] && $value[1] == $nrp){
                                echo "<td><input type='text' value='".$value[2]."' name='$nrp-".$arrKode[$i]."'></td>";
                                $data+=1;
                            }
                        }
                        if($data == $i){
                            echo "<td><input type='text' value='-' name='$nrp-".$arrKode[$data]."'></td>";
                            $data+=1;
                        }
                    }
                    echo "</tr>";
                }
                
            ?>
        </table>
        <input type="submit" value="Simpan" name="btnSimpan" id="btnSimpan">
    </form>
</body>
</html>