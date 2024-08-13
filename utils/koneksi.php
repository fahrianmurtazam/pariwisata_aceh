<?php
$server = "localhost";
$user = "root";
$password = "";
$nama_database = "daftar_pesanan";
$port = 3307; // Port MySQL yang digunakan
$koneksi = mysqli_connect($server, $user, $password, $nama_database, $port);
    if( !$koneksi ){
    die("Gagal terhubung dengan database: " . mysqli_connect_error());
    } 
?>