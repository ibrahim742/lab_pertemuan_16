<?php

$server = "localhost";
$username = "root";
$password = "";
$dbname = "kasrt";

$koneksi = mysqli_connect($server, $username, $password, $dbname) or die("Koneksi database gagal");
