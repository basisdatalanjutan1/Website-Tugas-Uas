<?php
$db_host    = "localhost";
$db_user    = "root";
$db_pass    = "";
$db_name    = "koneksi";

$koneksi    = mysqli_connect("localhost", "root", "", "sekolah");
if (!$koneksi) {
    die("Koneksi Gagal");
}