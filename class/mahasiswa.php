<?php
    require("koneksi.php");

    class Mahasiswa extends Koneksi{

        public function __construct($server, $user, $pass, $db){
            parent::__construct($server, $user, $pass, $db);
        }
        
        public function GetMahasiswa(){
            $sql = "SELECT * FROM mahasiswa";
            $res = $this->con->query($sql);

            return $res;
        }
        public function __destruct()
        {
            $this->con->close();
        }
        // public function GetKodeMk(){
        //     $sql = "SELECT nama FROM matakuliah";
        //     $res = $this->con->query($sql);

        //     while ($row = $res->fetch()
        // }
    }
?>