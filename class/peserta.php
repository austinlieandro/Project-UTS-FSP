<?php
    require_once("koneksi.php");

    class Peserta extends Koneksi{

        public function __construct($server,$user, $pass, $db){
            parent::__construct($server,$user,$pass,$db);
        }
        public function GetPesertaByKode($kodeMatkul){
            $sql = "SELECT m.nama,p.nrp,p.nilai FROM peserta p INNER JOIN mahasiswa m ON m.nrp=p.nrp WHERE p.kode = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param('s', $kodeMatkul);
            $stmt->execute();
            $res = $stmt->get_result();

            return $res;
        }
        public function GetPeserta(){
            $data_peserta = array();

            $sql = "SELECT * FROM peserta ORDER BY nrp ASC";
            $res = $this->con->query($sql);
            while ($row = $res->fetch_assoc()) {
                $kode = $row['kode'];
                $nrp = $row['nrp'];
                $nilai = $row['nilai'];

                array_push($data_peserta,array($kode,$nrp,$nilai));
            }
            
            return $data_peserta;
        }
        public function CekNilai($nrp,$kode){
            $sql = "SELECT nilai FROM peserta WHERE nrp = $nrp and kode = $kode";
            $res = $this->con->query($sql);
            
            if ($row = $res->fetch_assoc()) {
                $data = 1;
            }
            else{
                $data = 0;
            }

            return $data;
        }
        public function ExecuteDML($kode,$nrp,$nilai,$cmd){
            if($cmd == "insert"){
                $sql = "INSERT INTO peserta VALUES (?,?,?)";
                $stmt = $this->con->prepare($sql);
                $stmt->bind_param("ssd",$kode,$nrp,$nilai);
                $stmt->execute();
            }
            else if($cmd == "update"){
                $sql = "UPDATE peserta SET nilai = ? WHERE kode = ? AND nrp = ?";
                $stmt = $this->con->prepare($sql);
                $stmt->bind_param("dss",$nilai,$kode,$nrp);
                $stmt->execute();
            }
            else if($cmd == "delete"){
                $sql = "DELETE FROM peserta WHERE nrp = ? AND kode = ?";
                $stmt = $this->con->prepare($sql);
                $stmt->bind_param("ss", $nrp,$kode);
                $stmt->execute();
            }
        }
        public function __destruct()
        {
            $this->con->close();
        }
    }
?>