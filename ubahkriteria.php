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

//mengatur 6 karakter sebagai jumlah karakter yang tetap
//mengatur 3 karakter untuk jumlah karakter yang berubah-ubah
$noUrut = (int) substr($nim, 2, 3);
$noUrut++;

//menjadikan 201353 sebagai 6 karakter yang tetap
$char = "kr";
//%03s untuk mengatur 3 karakter di belakang 201353
$IDbaru = $char . sprintf("%03s", $noUrut);

//ambil data
$id = mysqli_real_escape_string($conn, $_GET['id']);
$s = mysqli_query($conn, "SELECT * FROM kriteria WHERE id_kriteria='$id'");
$d = mysqli_fetch_assoc($s);
//untuk tombol ubah
if (isset($_POST['ubah'])) {
    $s = mysqli_query($conn, "update kriteria set nama_kriteria='$_POST[nama_kriteria]', bobot='$_POST[bobot]', poin1='$_POST[poin1]',poin2='$_POST[poin2]', poin3='$_POST[poin3]', poin4='$_POST[poin4]', poin5='$_POST[poin5]', sifat='$_POST[sifat]' where id_kriteria='$_POST[id_kriteria]'");

    if ($s) {
        echo "<script>window.open('kriteria.php','_self');</script>";
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>

<body>
    <nav class='navbar navbar-expand-lg navbar-dark bg-dark text-light '>
        <div class="container">
            <a href="kriteria.php" class="navbar-brand">App-TOPSIS</a>
            <button class="navbar-toggler" type="button" data-togle="collapse">
                <span class="navbar-toggler-icon"></span>
            </button> &nbsp; &nbsp;
            <a href="kriteria.php" class="navbar-brand">Kriteria</a>
            <a href="alternatif.php" class="navbar-brand">Alternatif</a>
            <a href="inputnilaimatriks.php" class="navbar-brand">Nilai Matriks</a>
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
                <h3 class="box-title">Ubah Data Kriteria</h3>
                <br>
            </div>
            <form action="" method="POST">

                <input type="text" name="id_kriteria" class="form-control" value="<?php echo $d['id_kriteria']; ?>" readonly>
                <br />
                <input type="text" name="nama_kriteria" class="form-control" placeholder="Nama Kriteria" value="<?php echo $d['nama_kriteria']; ?>">
                <br />
                <input type="text" name="bobot" class="form-control" placeholder="Bobot" value="<?php echo $d['bobot']; ?>">
                <br />
                <input type="text" name="poin1" class="form-control" placeholder="Poin 1" value="<?php echo $d['poin1']; ?>">
                <br />
                <input type="text" name="poin2" class="form-control" placeholder="Poin 2" value="<?php echo $d['poin2']; ?>">
                <br />
                <input type="text" name="poin3" class="form-control" placeholder="Poin 3" value="<?php echo $d['poin3']; ?>">
                <br />
                <input type="text" name="poin4" class="form-control" placeholder="Poin 4" value="<?php echo $d['poin4']; ?>">
                <br />
                <input type="text" name="poin5" class="form-control" placeholder="Poin 5" value="<?php echo $d['poin5']; ?>">
                <br />
                <select name="sifat" class="form-control">
                    <option value="<?php echo $d['sifat']; ?>"><?php echo $d['sifat']; ?></option>
                    <option value="benefit">Benefit</option>
                    <option value="cost">Cost</option>
                </select>
                <br />
                <input type="submit" name="ubah" value="Ubah" class="btn btn-primary"> &nbsp;
                <a href="kriteria.php" class="btn btn-primary">Kembali</a>
                <br />
            </form>
        </div>
    </div>
</body>
<!-- Bootstrap requirement jQuery pada posisi pertama, kemudian Popper.js, dan  yang terakhit Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>