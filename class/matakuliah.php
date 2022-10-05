<?php
    require("koneksi.php");

    class Matakuliah extends Koneksi{
        private $kode;
        private $nama;

        public function __construct(){
            $this->kode = 0;
            $this->nama = "";
        }
        
        public function GetData(){
            $sql = "SELECT * FROM matakuliah";

        }
    }
?>