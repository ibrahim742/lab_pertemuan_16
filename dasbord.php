<?php


$host = "localhost";
$user = "root";
$pass = "";
$db = "kasrt";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //Cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$nik    = "";
$nama   = "";
$sex    = "";
$alamat = "";
$blok   = "";
$sukses = "";
$error = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = "delete from table_kas where id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil hapus data";
    } else {
        $error = "Gagal melakukan hapus data";
    }
}

if ($op == 'edit') {
    $id = $_GET['id'];
    $sql1 = "select * from table_kas where id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);
    $nik = $r1['nik'];
    $nama = $r1['nama'];
    $sex = $r1['sex'];
    $alamat = $r1['alamat'];
    $blok = $r1['blok'];

    if ($nik == '') {
        $error = "Data tidak ditemukan";
    }
}

if (isset($_POST['simpan'])) { //untuk create
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $sex = $_POST['sex'];
    $alamat = $_POST['alamat'];
    $blok = $_POST['blok'];

    if ($nik && $nama && $sex && $alamat && $blok) { //Untuk update
        if ($op == 'edit') {
            $sql1 = "update table_kas set nik = '$nik', nama = '$nama', sex = '$sex', alamat = '$alamat', blok = '$blok' where id = '$id'";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error = "Data gagal diupdate";
            }
        } else { //untuk inssert
            $sql1 = "insert into table_kas (nik,nama,sex,alamat,blok) values ('$nik', '$nama', '$sex', '$alamat', '$blok')";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Berhasil memasukan data";
            } else {
                $error = "Gagal memasukan data";
            }
        }
    } else {
        $error = "Silahkan masukan data semua";
    }
}


?>


<?php

// Mengunci halaman agar tidak bisa akses tanpa login
// require_once('function/helper.php');

// // session_start();
// if ($_SESSION['id'] == null) {
//     header("location: " . BASE_URL);
//     exit();
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iuran Kas RT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <style>
        .mx-auto {
            width: 800px;
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- Untuk Masukan Data -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                CREATE INPUT DATA
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php

                    header("refresh:3;url=dasbord.php"); //5 Untuk menandakan 5 detik refresh

                }
                ?>

                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php

                    header("refresh:3;url=dasbord.php"); //5 Untuk menandakan 5 detik refresh

                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nik" class="col-sm-2 col-form-label">NIK</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nik" name="nik" value="<?php echo $nik ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">NAMA</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="sex" class="col-sm-2 col-form-label">KELAMIN</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="sex" name="sex">
                                <option value="">- Jenis Kelamin -</option>
                                <option value="P" <?php if ($sex == "p") echo "selected" ?>>P</option>
                                <option value="L" <?php if ($sex == "l") echo "selected" ?>>L</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">ALAMAT</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat ?>">
                        </div>
                    </div>


                    <div class="mb-3 row">
                        <label for="blok" class="col-sm-2 col-form-label">BLOK</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="blok" name="blok" value="<?php echo $blok ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>

        <!-- Untuk Mengeluarkan Data -->
        <div class="card">
            <div class="card-header bg-success text-white">
                HASIL DATA
            </div>
            <div class="card-body">
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th scope="col" align="center">#</th>
                            <th scope="col">NIK</th>
                            <th scope="col">NAMA</th>
                            <th scope="col">KELAMIN</th>
                            <th scope="col">ALAMAT</th>
                            <th scope="col">BLOK</th>
                            <th scope="col">AKSI</th>
                        </tr>
                    <tbody>
                        <?php
                        $sql2 = "select * from table_kas order by id desc";
                        $q2 = mysqli_query($koneksi, $sql2);
                        $urut = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id     = $r2['id'];
                            $nik    = $r2['nik'];
                            $nama   = $r2['nama'];
                            $sex    = $r2['sex'];
                            $alamat = $r2['alamat'];
                            $blok   = $r2['blok'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $nik ?></td>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $sex ?></td>
                                <td scope="row"><?php echo $alamat ?></td>
                                <td scope="row"><?php echo $blok ?></td>
                                <td scope="row">
                                    <a href="dasbord.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="dasbord.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Apakah anda mau menghapus data?')"><button type=" button" class="btn btn-danger">Hapus</button></a>

                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <!-- Asset plugin datables -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>
</body>

</html>