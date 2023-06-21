<?php
//inisialisasi session
session_start();
//mengecek username pada session
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = 'anda harus login untuk mengakses halaman ini';
    header('Location: login.php');
}
include("koneksi.php");
$s = mysqli_query($conn, "select * from alternatif where id_alternatif='$_GET[id]'");
$d = mysqli_fetch_assoc($s);
//untuk tombol ubah
if (isset($_POST['ubah'])) {
    $s = mysqli_query($conn, "update alternatif set nm_alternatif='$_POST[nama_alternatif]' where id_alternatif='$_POST[id_alternatif]'");

    if ($s) {
        echo "<script>window.open('alternatif.php','_self');</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/4.1.3/bootstrap.min.css">
    <link href="bootstrap/css/3.3.7/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class='navbar navbar-expand-lg navbar-dark bg-dark text-light '>
        <div class="container">
            <a href="index.php" class="navbar-brand">App-TOPSIS</a>
            <button class="navbar-toggler" type="button" data-togle="collapse">
                <span class="navbar-toggler-icon"></span>
            </button> &nbsp; &nbsp;
            <a href="index.php" class="navbar-brand">Kriteria</a>
            <a href="alternatif.php" class="navbar-brand">Alternatif</a>
            <a href="inputnilaimatriks.php" class="navbar-brand">Input Matriks</a>
            <a href="hasiltopsis.php" class="navbar-brand">Hasil Topsis</a>
            <ul class="navbar-nav ml-auto pt-2 pb-2">
                <li class="nav-item ml-4">
                    <a href="logout.php" class="nav-link text-light"> Log Out </a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="jumbotron jumbotron-fluid bg-light" style="height:90vh">
        <div class="container">
            <div class="box-header">
                <h3 class="box-title">Ubah Data Alternatif</h3>
                <br>
            </div>
            <div class="box-body pad">
                <form action="" method="POST">

                    <input type="text" name="id_alternatif" class="form-control" value="<?php echo $d['id_alternatif']; ?>" readonly>
                    <br />
                    <input type="text" name="nama_alternatif" class="form-control" placeholder="Nama Alternatif" value="<?php echo $d['nm_alternatif']; ?>">
                    <br />
                    <input type="submit" name="ubah" value="Ubah" class="btn btn-primary"> &nbsp;
                    <a href="alternatif.php" class="btn btn-primary">Kembali</a>
                    <br />
                </form>
            </div>
        </div>
    </div>
</body>
<!-- Bootstrap requirement jQuery pada posisi pertama, kemudian Popper.js, dan  yang terakhit Bootstrap JS -->
<script src="bootstrap/js/jquery-3.3.1.slim.min.js"></script>
<script src="bootstrap/js/popper.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>