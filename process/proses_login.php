<?php

require_once('../function/helper.php');
require_once('../function/koneksi.php');

// Menangkap Request
$username = $_POST['username'];
$password = md5($_POST['password']);

// var_dump($username);
// die();

$query = mysqli_query($koneksi, "SELECT * FROM  akun WHERE username = '$username' AND password = '$password'");

// Mengecek pengguna
if (mysqli_num_rows($query) != 0) {
    $row = mysqli_fetch_assoc($query);

    // Membuat sesion
    session_start();
    $_SESSION['id'] = $row['id'];
    header("location: " . BASE_URL . 'dasbord.php');
} else {
    header("location: " . BASE_URL);
}
