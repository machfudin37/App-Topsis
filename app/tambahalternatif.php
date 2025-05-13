<?php
//inisialisasi session
session_start();
//mengecek username pada session
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = 'anda harus login untuk mengakses halaman ini';
    header('Location: login.php');
}
include("koneksi.php");


//untuk tombol simpan
if (isset($_POST['simpan'])) {
    $s = mysqli_query($conn, "insert into alternatif (id_alternatif,nm_alternatif) values('$_POST[id_alternatif]','$_POST[nama_alternatif]')");

    if ($s && mysqli_affected_rows($conn) > 0) {
        echo '<script>alert("Alternatif berhasil ditambahkan"); window.open("alternatif.php", "_self");</script>';
    } else {
        echo '<script>alert("Alternatif gagal ditambahkan"); window.history.back();</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Tambah Alternatif | App-Topsis</title>
    <link rel="apple-touch-icon" sizes="57x57" href="assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Vendors styles-->
    <link rel="stylesheet" href="assets/vendors/simplebar/css/simplebar.css">
    <link rel="stylesheet" href="assets/css/vendors/simplebar.css">
    <?php include 'layout/head.php'; ?>
</head>

<body>
    <?php include 'layout/sidebar.php'; ?>
    <div class="wrapper d-flex flex-column min-vh-100">
        <?php include 'layout/header.php'; ?>
        <div class="container-lg px-4">
            <div class="card mb-4">
                <div class="card-header"><strong>Tambah Data Alternatif</strong></div>
                <div class="container-lg px-4">
                    <br>
                    <form action="" method="POST">
                        <div class="input-group mb-3">
                            <input class="form-control" name="id_alternatif" id="id_alternatif" type="text"
                                placeholder="Masukan Kode Alternatif">
                        </div>
                        <div class="input-group mb-3">
                            <input class="form-control" name="nama_alternatif" id="nama_alternatif" type="text"
                                placeholder="Masukan Nama Kriteria">
                        </div>
                        <div class="col-6 mb-2">
                            <input class="btn btn-block btn-success" type="submit" name="simpan" value="Simpan">
                            <a href="alternatif.php" class="btn btn-block btn-primary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php include 'layout/footer.php'; ?>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="assets/vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
    <script src="assets/vendors/simplebar/js/simplebar.min.js"></script>
    <script>
    const header = document.querySelector('header.header');

    document.addEventListener('scroll', () => {
        if (header) {
            header.classList.toggle('shadow-sm', document.documentElement.scrollTop > 0);
        }
    });
    </script>
    <!-- Plugins and scripts required by this view-->
    <script src="assets/vendors/chart.js/js/chart.umd.js"></script>
    <script src="assets/vendors/@coreui/chartjs/js/coreui-chartjs.js"></script>
    <script src="assets/vendors/@coreui/utils/js/index.js"></script>
    <script src="assets/js/main.js"></script>

</body>

</html>