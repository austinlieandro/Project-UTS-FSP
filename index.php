<?php
    $link = "#";
    $conn = new mysqli("localhost", "root", "", "fsputspro");
    if (isset($_GET['btnpilih'])) {
        //$link = "#";
        $kodeMatkul = $_GET['cmbMataKuliah'];
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Awal</title>
    <script type="text/javascript" src="jquery-3.6.0.js"></script>
    <style>
        table,
        th,
        td,
        tr {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <form action="#" method="get">
        Mata Kuliah :
        <select name="cmbMataKuliah" id="">
            <option value="1">--Pilih Mata Kuliah--</option>
            <?php
            $sql = "SELECT * FROM matakuliah";
            $res = $conn->query($sql);
            while ($row = $res->fetch_assoc()) {
                if ($kodeMatkul == $row["kode"]) {
                    echo "<option value='" . $row['kode'] . "' selected>" . $row['nama'] . "</option>";
                } else {
                    echo "<option value=" . $row['kode'] . ">" . $row['nama'] . "</option>";
                }
            }
            ?>
        </select>
        <input type="submit" name="btnpilih" value="Pilih">

        <table>
            <th>Peserta</th>
            <th>E</th>
            <th>D</th>
            <th>C</th>
            <th>BC</th>
            <th>B</th>
            <th>AB</th>
            <th>A</th>
            <?php
                $sql1 = "SELECT m.nama,p.nrp,p.nilai FROM peserta p INNER JOIN mahasiswa m ON m.nrp=p.nrp WHERE p.kode = ?";
                $stmt1 = $conn->prepare($sql1);
                $stmt1->bind_param('s', $kodeMatkul);
                $stmt1->execute();
                $res1 = $stmt1->get_result();
                if($res1->num_rows < 1){
                    if($kodeMatkul == 1){
                        echo "<tr><td colspan='8'>Mata Kuliah Belum Ditentukan</td></tr>";
                    }
                    else{
                        echo "<tr><td colspan='8'>Tidak Ada Peserta Untuk Mata Kuliah Ini</td></tr>";
                    }
                }
                else
                {    while ($row1 = $res1->fetch_assoc()) {
                        //$kode = $row1['kode'];
                        $nrp = $row1['nrp'];
                        $nilai = $row1['nilai'];
                        $nama = $row1['nama'];
                        $kolom = 1;
                        echo "<tr>";
                        if ($nilai >= 81) {
                            $kolom = 7;
                        } else if ($nilai >= 73) {
                            $kolom = 6;
                        } else if ($nilai >= 66) {
                            $kolom = 5;
                        } else if ($nilai >= 60) {
                            $kolom = 4;
                        } else if ($nilai >= 55) {
                            $kolom = 3;
                        } else if ($nilai >= 40) {
                            $kolom = 2;
                        } else {
                            $kolom = 1;
                        }
                        for ($i = 0; $i < 8; $i++) {
                            if ($i == 0) {
                                echo "<td>$nrp-$nama</td>";
                            } else if ($i % $kolom == 0) {
                                echo "<td>$nilai</td>";
                            } else {
                                echo "<td></td>";
                            }
                        }
                        echo "</tr>";
                    }
                }
                
            ?>
        </table>
        <input type="button" name="btnEdit" value="Ubah Peserta" id="btnEdit">
    </form>
    <script type="text/javascript" src="jq.js"></script>
</body>

</html>