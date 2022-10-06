<?php
    require("koneksi.php");

    class Peserta extends Koneksi{

        public function __construct($server,$user, $pass, $db){
            parent::__construct($server,$user,$pass,$db);
        }
        public function GetPeserta($kodeMatkul){
            //$sql = "SELECT * FROM matakuliah";
            $sql = "SELECT m.nama,p.nrp,p.nilai FROM peserta p INNER JOIN mahasiswa m ON m.nrp=p.nrp WHERE p.kode = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('s', $kodeMatkul);
            $stmt->execute();
            $res = $stmt->get_result();

            return $res;
        }
        public function __destruct()
        {
            $this->con->close();
        }
    }
?>