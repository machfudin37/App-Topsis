<?php
//inisialisasi session
session_start();
//mengecek username pada session
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = 'anda harus login untuk mengakses halaman ini';
    header('Location: login.php');
}
include("koneksi.php");


$query = "SELECT max(id_alternatif) as idMaks FROM alternatif";
$hasil = mysqli_query($conn, $query);
$data  = mysqli_fetch_array($hasil);
$nim = $data['idMaks'];

//mengatur 6 karakter sebagai jumalh karakter yang tetap
//mengatur 3 karakter untuk jumlah karakter yang berubah-ubah
$noUrut = (int) substr($nim, 2, 3);
$noUrut++;

//menjadikan 201353 sebagai 6 karakter yang tetap
$char = "al";
//%03s untuk mengatur 3 karakter di belakang 201353
$IDbaru = $char . sprintf("%03s", $noUrut);
//untuk tombol simpan
if (isset($_POST['simpan'])) {
    $s = mysqli_query($conn, "insert into alternatif (id_alternatif,nm_alternatif) values('$_POST[id_alternatif]','$_POST[nama_alternatif]')");

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
                <h3 class="box-title">Tambah Data Alternatif</h3>
                <br>
            </div>
            <div class="box-body pad">
                <form action="" method="POST">

                    <input type="text" name="id_alternatif" class="form-control" value="<?php echo $IDbaru; ?>" readonly>
                    <br />
                    <input type="text" name="nama_alternatif" class="form-control" placeholder="Nama Alternatif">
                    <br />
                    <input type="submit" name="simpan" value="Simpan" class="btn btn-primary"> &nbsp;
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