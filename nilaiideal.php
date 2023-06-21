<?php
//inisialisasi session
session_start();
//mengecek username pada session
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = 'anda harus login untuk mengakses halaman ini';
    header('Location: login.php');
}
include("koneksi.php");
$s = mysqli_query($conn, "select * from kriteria");
$h = mysqli_num_rows($s);

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
                <h3 class="box-title">Data Hasil Topsis</h3>
                <br>
                <a href="nilaimatriks.php" class="btn btn-large btn-default">

                    <i class="glyphicon glyphicon"></i>

                    &nbsp; Nilai Matriks</a>
                <a href="nilaimatriksternormalisasi.php" class="btn btn-large btn-default">

                    <i class="glyphicon glyphicon"></i>

                    &nbsp; Nilai Matrik Ternormalisasi</a>
                <a href="nilaibobotternormalisasi.php" class="btn btn-large btn-default">

                    <i class="glyphicon glyphicon"></i>

                    &nbsp; Nilai Bobot Ternormalisasi</a>
                <a href="nilaiideal.php" class="btn btn-large btn-default">

                    <i class="glyphicon glyphicon"></i>

                    &nbsp; Nilai Ideal Positif/Negatif</a>
                <a href="jaraksolusiideal.php" class="btn btn-large btn-default">

                    <i class="glyphicon glyphicon"></i>

                    &nbsp; Jarak Solusi Ideal Positif/Negatif</a>
                <a href="nilaipreferensi.php" class="btn btn-large btn-default">

                    <i class="glyphicon glyphicon"></i>

                    &nbsp; Nilai Preferensi</a>
            </div>
            <div class="table-responsive">
                <div class="table table-bordered table-responsive">
                    <div class="box-header">
                        <h3 class="box-title ">Matriks Ideal Positif (A<sup>+</sup>)</h3>
                    </div>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th colspan="<?php echo $h; ?>">
                                    <center>Kriteria</center>
                                </th>
                            </tr>
                            <tr>
                                <?php
                                $hk = mysqli_query($conn, "select nama_kriteria from kriteria order by id_kriteria asc;");
                                while ($dhk = mysqli_fetch_assoc($hk)) {

                                    echo "<th>$dhk[nama_kriteria]</th>";
                                }
                                ?>
                            </tr>
                            <tr>
                                <?php

                                for ($n = 1; $n <= $h; $n++) {

                                    echo "<th>y<sub>$n</sub><sup>+</sup></th>";
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $a = mysqli_query($conn, "select * from kriteria order by id_kriteria asc;");
                            echo "<tr>";
                            while ($da = mysqli_fetch_assoc($a)) {
                                $idalt = $da['id_kriteria'];
                                //ambil nilai
                                $n = mysqli_query($conn, "select * from nilai_matrik where id_kriteria='$idalt'  order by id_matrik ASC");

                                $c = 0;
                                $ymax = array();
                                while ($dn = mysqli_fetch_assoc($n)) {
                                    $idk = $dn['id_kriteria'];
                                    //nilai kuadrat
                                    $nilai_kuadrat = 0;
                                    $k = mysqli_query($conn, "select * from nilai_matrik where id_kriteria='$idk'  order by id_matrik ASC ");
                                    while ($dkuadrat = mysqli_fetch_assoc($k)) {
                                        $nilai_kuadrat = $nilai_kuadrat + ($dkuadrat['nilai'] * $dkuadrat['nilai']);
                                    }
                                    //hitung jml alternatif
                                    $jml_alternatif = mysqli_query($conn, "select * from alternatif");
                                    $jml_a = mysqli_num_rows($jml_alternatif);
                                    //nilai bobot kriteria (rata")
                                    $bobot = 0;
                                    $tnilai = 0;
                                    $k2 = mysqli_query($conn, "select * from nilai_matrik where id_kriteria='$idk'  order by id_matrik ASC ");
                                    while ($dbobot = mysqli_fetch_assoc($k2)) {
                                        $tnilai = $tnilai + $dbobot['nilai'];
                                    }
                                    $bobot = $tnilai / $jml_a;
                                    //nilai bobot input
                                    $b2 = mysqli_query($conn, "select * from kriteria where id_kriteria='$idk'");
                                    $nbot = mysqli_fetch_assoc($b2);
                                    $bot = $nbot['bobot'];
                                    $v = round(($dn['nilai'] / sqrt($nilai_kuadrat)) * $bot, 4);

                                    $ymax[$c] = $v;
                                    $c++;
                                }
                                if ($nbot['sifat'] == 'benefit') {
                                    //echo "<pre>";    
                                    //print_r($ymax);    
                                    //echo "</pre>";    
                                    echo "<td>" . max($ymax) . "</td>";
                                } else {
                                    echo "<td>" . min($ymax) . "</td>";
                                }
                            }
                            echo "</tr>";
                            ?>

                        </tbody>
                    </table>

                    <!-- tabel min -->

                    <div class="box-header">
                        <h3 class="box-title ">Matriks Ideal Negatif (A<sup>-</sup>)</h3>
                    </div>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th colspan="<?php echo $h; ?>">
                                    <center>Kriteria</center>
                                </th>
                            </tr>
                            <tr>
                                <?php
                                $hk = mysqli_query($conn, "select nama_kriteria from kriteria order by id_kriteria asc;");
                                while ($dhk = mysqli_fetch_assoc($hk)) {

                                    echo "<th>$dhk[nama_kriteria]</th>";
                                }
                                ?>
                            </tr>
                            <tr>
                                <?php
                                for ($n = 1; $n <= $h; $n++) {
                                    echo "<th>y<sub>$n</sub><sup>-</sup></th>";
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $a = mysqli_query($conn, "select * from kriteria order by id_kriteria asc;");
                            echo "<tr>";
                            while ($da = mysqli_fetch_assoc($a)) {
                                $idalt = $da['id_kriteria'];

                                //ambil nilai

                                $n = mysqli_query($conn, "select * from nilai_matrik where id_kriteria='$idalt'  order by id_matrik ASC");

                                $c = 0;
                                $ymax = array();
                                while ($dn = mysqli_fetch_assoc($n)) {
                                    $idk = $dn['id_kriteria'];


                                    //nilai kuadrat

                                    $nilai_kuadrat = 0;
                                    $k = mysqli_query($conn, "select * from nilai_matrik where id_kriteria='$idk' order by id_matrik ASC ");
                                    while ($dkuadrat = mysqli_fetch_assoc($k)) {
                                        $nilai_kuadrat = $nilai_kuadrat + ($dkuadrat['nilai'] * $dkuadrat['nilai']);
                                    }

                                    //hitung jml alternatif
                                    $jml_alternatif = mysqli_query($conn, "select * from alternatif");
                                    $jml_a = mysqli_num_rows($jml_alternatif);
                                    //nilai bobot kriteria (rata")
                                    $bobot = 0;
                                    $tnilai = 0;

                                    $k2 = mysqli_query($conn, "select * from nilai_matrik where id_kriteria='$idk' order by id_matrik ASC ");
                                    while ($dbobot = mysqli_fetch_assoc($k2)) {
                                        $tnilai = $tnilai + $dbobot['nilai'];
                                    }
                                    $bobot = $tnilai / $jml_a;

                                    //nilai bobot input
                                    $b2 = mysqli_query($conn, "select * from kriteria where id_kriteria='$idk'");
                                    $nbot = mysqli_fetch_assoc($b2);
                                    $bot = $nbot['bobot'];


                                    $v = round(($dn['nilai'] / sqrt($nilai_kuadrat)) * $bot, 4);

                                    $ymax[$c] = $v;
                                    $c++;
                                }

                                if ($nbot['sifat'] == 'cost') {
                                    echo "<td>" . max($ymax) . "</td>";
                                } else {
                                    echo "<td>" . min($ymax) . "</td>";
                                }
                            }
                            echo "</tr>";
                            ?>

                        </tbody>
                    </table>
                </div>
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