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
                    <h3 class="box-title ">Nilai Matriks</h3>
                </div>
                <div class="table table-bordered table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Nama</th>
                                <th colspan="<?php echo $h; ?>">Kriteria</th>
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
                            $a = mysqli_query($conn, "select * from alternatif order by id_alternatif asc;");
                            while ($da = mysqli_fetch_assoc($a)) {
                                echo "<tr>
		<td>" . (++$i) . "</td>
		<td>" . $da['nm_alternatif'] . "</td>";
                                $idalt = $da['id_alternatif'];
                                //ambil nilai
                                $n = mysqli_query($conn, "select * from nilai_matrik where id_alternatif='$idalt' order by id_matrik asc");

                                while ($dn = mysqli_fetch_assoc($n)) {

                                    echo "<td align='center'>$dn[nilai]</td>";
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
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>