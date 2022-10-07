<?php
    require("koneksi.php");

    class Matakuliah extends Koneksi{

        public function __construct($server, $user, $pass, $db){
            parent::__construct($server, $user, $pass, $db);
        }
        
        public function GetMatakuliah(){
            $sql = "SELECT * FROM matakuliah";
            $res = $this->con->query($sql);

            return $res;
        }
        public function GetKodeMk(){
            $sql = "SELECT kode FROM matakuliah";
            $res = $this->con->query($sql);
            $arr = array();

            while ($row = $res->fetch_array()){
                $arr[] = $row['kode'];
            }
            return $arr;
        }
        public function __destruct()
        {
            $this->con->close();
        }
    }
?>