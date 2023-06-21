<?php
//inisialisasi session
session_start();
//mengecek username pada session
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = 'anda harus login untuk mengakses halaman ini';
    header('Location: login.php');
}
include("koneksi.php");


$query = "SELECT max(id_kriteria) as idMaks FROM kriteria";
$hasil = mysqli_query($conn, $query);
$data  = mysqli_fetch_array($hasil);
$nim = $data['idMaks'];

//mengatur 6 karakter sebagai jumalh karakter yang tetap
//mengatur 3 karakter untuk jumlah karakter yang berubah-ubah
$noUrut = (int) substr($nim, 2, 3);
$noUrut++;

//menjadikan 201353 sebagai 6 karakter yang tetap
$char = "kr";
//%03s untuk mengatur 3 karakter di belakang 201353
$IDbaru = $char . sprintf("%03s", $noUrut);
// untuk tombol simpan
if (isset($_POST['simpan'])) {
    $s = mysqli_query($conn, "insert into kriteria (id_kriteria,nama_kriteria,bobot,poin1,poin2,poin3,poin4,poin5,sifat) values ('$_POST[id_kriteria]','$_POST[nama_kriteria]','$_POST[bobot]','$_POST[poin1]','$_POST[poin2]','$_POST[poin3]','$_POST[poin4]','$_POST[poin5]','$_POST[sifat]')");

    if ($s) {
        echo "<script>window.open('index.php','_self');</script>";
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
                <h3 class="box-title">Tambah Data Kriteria</h3>
                <br>
            </div>
            <form action="" method="POST">

                <input type="text" name="id_kriteria" class="form-control" value="<?php echo $IDbaru; ?>" readonly>
                <br />
                <input type="text" name="nama_kriteria" class="form-control" placeholder="Nama Kriteria">
                <br />
                <input type="text" name="bobot" class="form-control" placeholder="Bobot">
                <br />
                <input type="text" name="poin1" class="form-control" placeholder="Poin 1">
                <br />
                <input type="text" name="poin2" class="form-control" placeholder="Poin 2">
                <br />
                <input type="text" name="poin3" class="form-control" placeholder="Poin 3">
                <br />
                <input type="text" name="poin4" class="form-control" placeholder="Poin 4">
                <br />
                <input type="text" name="poin5" class="form-control" placeholder="Poin 5">
                <br />
                <select name="sifat" class="form-control">
                    <option value="benefit">Benefit</option>
                    <option value="cost">Cost</option>
                </select>
                <br />
                <input type="submit" name="simpan" value="Simpan" class="btn btn-primary"> &nbsp;
                <a href="index.php" class="btn btn-primary">Kembali</a>
                <br />
            </form>
        </div>
    </div>
</body>
<!-- Bootstrap requirement jQuery pada posisi pertama, kemudian Popper.js, dan  yang terakhit Bootstrap JS -->
<script src="bootstrap/js/jquery-3.3.1.slim.min.js"></script>
<script src="bootstrap/js/popper.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>

</html>