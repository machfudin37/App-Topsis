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
                <div class="box-header">
                    <h3 class="box-title ">Nilai Matriks Ternormalisasi</h3>
                </div>
                <div class="table table-bordered table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Nama</th>
                                <th colspan="<?php echo $h; ?>">
                                    <center>Kriteria</center>
                                </th>
                            </tr>
                            <tr>
                                <?php
                                for ($n = 1; $n <= $h; $n++) {
                                    echo "<th>C{$n}</th>";
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $a = mysqli_query($conn, "select * from alternatif order by id_alternatif asc");
                            while ($da = mysqli_fetch_assoc($a)) {
                                echo "<tr>
		<td>" . (++$i) . "</td>
		<td>$da[nm_alternatif]</td>";
                                $idalt = $da['id_alternatif'];

                                //ambil nilai

                                $n = mysqli_query($conn, "select * from nilai_matrik where id_alternatif='$idalt' order by id_matrik asc");

                                while ($dn = mysqli_fetch_assoc($n)) {
                                    $idk = $dn['id_kriteria'];

                                    //nilai kuadrat

                                    $nilai_kuadrat = 0;
                                    $k = mysqli_query($conn, "select * from nilai_matrik where id_kriteria='$idk' ");
                                    while ($dkuadrat = mysqli_fetch_assoc($k)) {
                                        $nilai_kuadrat = $nilai_kuadrat + ($dkuadrat['nilai'] * $dkuadrat['nilai']);
                                    }

                                    echo "<td align='center'>" . round(($dn['nilai'] / sqrt($nilai_kuadrat)), 3) . "</td>";
                                }
                                echo "</tr>\n";
                            }
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