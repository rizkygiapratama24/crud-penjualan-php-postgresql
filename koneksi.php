<?php
// konfigurasi koneksi
$host = "localhost";
$dbuser = "postgres";
$dbpass = "admin";
$port = "5432";
$dbname = "penjualan";

// script koneksi php postgree
$link = new PDO("pgsql:dbname=$dbname;host=$host", $dbuser, $dbpass);

if (!$link) {
    echo "Gagal Koneksi";
}
