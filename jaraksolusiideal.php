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
                <div class="table table-bordered table-responsive">
                    <div class="box-header">
                        <h3 class="box-title ">Jarak Solusi Ideal Positif (D<sup>+</sup>)</h3>
                    </div>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>
                                    <center>Nomor</center>
                                </th>
                                <th>
                                    <center>Nama</center>
                                </th>
                                <th>
                                    <center>D<sup>+</sup></center>
                                </th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php
                            //buat array kolom

                            $i2 = 1;
                            $i3 = 0;
                            $maxarray = array();
                            $a2 = mysqli_query($conn, "select * from kriteria order by id_kriteria asc;");
                            echo "<tr>";
                            while ($da2 = mysqli_fetch_assoc($a2)) {

                                $idalt2 = $da2['id_kriteria'];

                                //ambil nilai

                                $n2 = mysqli_query($conn, "select * from nilai_matrik where id_kriteria='$idalt2'  order by id_matrik ASC");
                                $jarakp2 = 0;
                                $c2 = 0;
                                $ymax2 = array();

                                while ($dn2 = mysqli_fetch_assoc($n2)) {
                                    $idk2 = $dn2['id_kriteria'];

                                    //nilai kuadrat

                                    $nilai_kuadrat2 = 0;
                                    $k2 = mysqli_query($conn, "select * from nilai_matrik where id_kriteria='$idk2' order by id_matrik ASC ");
                                    while ($dkuadrat2 = mysqli_fetch_assoc($k2)) {
                                        $nilai_kuadrat2 = $nilai_kuadrat2 + ($dkuadrat2['nilai'] * $dkuadrat2['nilai']);
                                    }

                                    //hitung jml alternatif
                                    $jml_alternatif2 = mysqli_query($conn, "select * from alternatif");

                                    $jml_a2 = mysqli_num_rows($jml_alternatif2);
                                    //nilai bobot kriteria (rata")
                                    $bobot2 = 0;
                                    $tnilai2 = 0;

                                    $k22 = mysqli_query($conn, "select * from nilai_matrik where id_kriteria='$idk2'  order by id_matrik ASC ");
                                    while ($dbobot2 = mysqli_fetch_assoc($k22)) {
                                        $tnilai2 = $tnilai2 + $dbobot2['nilai'];
                                    }
                                    $bobot2 = $tnilai2 / $jml_a2;

                                    //nilai bobot input
                                    $b2 = mysqli_query($conn, "select * from kriteria where id_kriteria='$idk2'");
                                    $nbot2 = mysqli_fetch_assoc($b2);
                                    $bot2 = $nbot2['bobot'];


                                    $v2 = round(($dn2['nilai'] / sqrt($nilai_kuadrat2)) * $bot2, 4);

                                    $ymax2[$c2] = $v2;
                                    $c2++;

                                    #cek benefit atau cost  
                                    // echo $nbot2['sifat']." - ".$nbot2['nama_kriteria']."<br>";


                                    if ($nbot2['sifat'] == 'benefit') {
                                        $mak2 = max($ymax2);
                                    } else {
                                        $mak2 = min($ymax2);
                                    } #cek benefit atau cost

                                }
                                /*				
echo "<i>ini ymax2</i>";    
echo "<pre>";    
print_r($ymax2);    
echo "</pre>";  
*/
                                //echo $mak2."| ";    
                                //hitung D+			
                                foreach ($ymax2 as $nymax2) {

                                    $jarakp2 = $jarakp2 + pow($nymax2 - $mak2, 2);
                                }

                                //array max
                                $maxarray[$i3] = $mak2;

                                //print_r($maxarray);
                                //print_r(max($ymax2));			
                                $i2++;
                                $i3++;
                            }
                            //session array ymax
                            $_SESSION['ymax'] = $maxarray;
                            /*    
echo "<i>ini min  max</i>";    
echo "<pre>";    
print_r($maxarray);    
echo "</pre>";    
*/

                            //array baris//////////////////////////////////////////////////
                            $i = 1;
                            $ii = 0;
                            $dpreferensi = array();

                            $a = mysqli_query($conn, "select * from alternatif order by id_alternatif asc;");
                            echo "<tr>";
                            while ($da = mysqli_fetch_assoc($a)) {

                                $idalt = $da['id_alternatif'];

                                //ambil nilai			
                                $n = mysqli_query($conn, "select * from nilai_matrik where id_alternatif='$idalt' order by id_matrik ASC");
                                $jarakp = 0;
                                $c = 0;
                                $ymax = array();
                                $arraymaks = array();
                                while ($dn = mysqli_fetch_assoc($n)) {
                                    $idk = $dn['id_kriteria'];

                                    //nilai kuadrat			
                                    $nilai_kuadrat = 0;
                                    $k = mysqli_query($conn, "select * from nilai_matrik where id_kriteria='$idk' order by id_matrik ASC ");
                                    while ($dkuadrat = mysqli_fetch_assoc($k)) {
                                        $nilai_kuadrat = $nilai_kuadrat + ($dkuadrat['nilai'] * $dkuadrat['nilai']);
                                    }

                                    //hitung jml alternatif
                                    $jml_alternatif = mysqli_query($conn, "select * from alternatif order by id_alternatif asc;");

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
                                    $mak = max($ymax);
                                }


                                /*    
echo "<i>ini bobot normalisasi</i>";        
echo "<pre>";    
print_r($ymax);    
echo "</pre>";   
*/

                                //hitung D+ 
                                foreach ($ymax as $nymax => $value) {
                                    $maks = $_SESSION['ymax'][$nymax];
                                    //echo $maks." - ";

                                    //echo $value."| ";

                                    $final = sqrt($jarakp = $jarakp + pow($value - $maks, 2));
                                    //echo $jarakp." || ";
                                }

                                echo "<tr>
		<td>$i</td>
		<td>$da[nm_alternatif]</td>
		<td>" . round($final, 4) . "</td>
		</tr>";
                                $dpreferensi[$ii] = round($final, 4);
                                $_SESSION['dplus'] = $dpreferensi;
                                //print_r($ymax);

                                $i++;
                                $ii++;
                            }

                            echo "</tr>";

                            ?>

                        </tbody>
                    </table>

                    <!-- tabel min ------------------------------------------------->

                    <div class="box-header">
                        <h3 class="box-title ">Jarak Solusi Ideal Negatif (D<sup>-</sup>)</h3>
                    </div>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>
                                    <center>Nomor</center>
                                </th>
                                <th>
                                    <center>Nama</center>
                                </th>
                                <th>
                                    <center>D<sup>-</sup></center>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //buat array kolom

                            $i2 = 1;
                            $i3 = 0;
                            $minarray = array();
                            $a2 = mysqli_query($conn, "select * from kriteria order by id_kriteria asc;");
                            echo "<tr>";
                            while ($da2 = mysqli_fetch_assoc($a2)) {

                                $idalt2 = $da2['id_kriteria'];

                                //ambil nilai

                                $n2 = mysqli_query($conn, "select * from nilai_matrik where id_kriteria='$idalt2' order by id_matrik ASC");
                                $jarakp2 = 0;
                                $c2 = 0;
                                $ymin2 = array();

                                while ($dn2 = mysqli_fetch_assoc($n2)) {
                                    $idk2 = $dn2['id_kriteria'];

                                    //nilai kuadrat

                                    $nilai_kuadrat2 = 0;
                                    $k2 = mysqli_query($conn, "select * from nilai_matrik where id_kriteria='$idk2' order by id_matrik ASC ");
                                    while ($dkuadrat2 = mysqli_fetch_assoc($k2)) {
                                        $nilai_kuadrat2 = $nilai_kuadrat2 + ($dkuadrat2['nilai'] * $dkuadrat2['nilai']);
                                    }

                                    //hitung jml alternatif
                                    $jml_alternatif2 = mysqli_query($conn, "select * from alternatif order by id_alternatif asc;");

                                    $jml_a2 = mysqli_num_rows($jml_alternatif2);
                                    //nilai bobot kriteria (rata")
                                    $bobot2 = 0;
                                    $tnilai2 = 0;

                                    $k22 = mysqli_query($conn, "select * from nilai_matrik where id_kriteria='$idk2' order by id_matrik ASC ");
                                    while ($dbobot2 = mysqli_fetch_assoc($k22)) {
                                        $tnilai2 = $tnilai2 + $dbobot2['nilai'];
                                    }
                                    $bobot2 = $tnilai2 / $jml_a2;

                                    //nilai bobot input
                                    $b2 = mysqli_query($conn, "select * from kriteria where id_kriteria='$idk2'");
                                    $nbot2 = mysqli_fetch_assoc($b2);
                                    $bot2 = $nbot2['bobot'];

                                    $v2 = round(($dn2['nilai'] / sqrt($nilai_kuadrat2)) * $bot2, 4);

                                    $ymin2[$c2] = $v2;
                                    $c2++;

                                    #cek benefit atau cost
                                    if ($nbot2['sifat'] == 'cost') {
                                        $min2 = max($ymin2);
                                    } else {
                                        $min2 = min($ymin2);
                                    } #cek benefit atau cost

                                    //$min2=min($ymin2);

                                }

                                //hitung D+

                                foreach ($ymin2 as $nymin2) {

                                    $jarakp2 = $jarakp2 + pow($nymin2 - $min2, 2);
                                    //echo "--".$mak."---";
                                }

                                //array max
                                $minarray[$i3] = $min2;

                                //print_r($maxarray);
                                //print_r(max($ymax2));

                                $i2++;
                                $i3++;
                            }
                            //session array ymax
                            $_SESSION['ymin'] = $minarray;

                            //array baris//////////////////////////////////////////////////
                            $i = 1;
                            $ii = 0;
                            $id_alt = array();
                            $a = mysqli_query($conn, "select * from alternatif order by id_alternatif asc;");
                            echo "<tr>";
                            while ($da = mysqli_fetch_assoc($a)) {

                                $idalt = $da['id_alternatif'];

                                //ambil nilai

                                $n = mysqli_query($conn, "select * from nilai_matrik where id_alternatif='$idalt' order by id_matrik ASC");
                                $jarakp = 0;
                                $c = 0;
                                $ymax = array();
                                $arraymin = array();
                                while ($dn = mysqli_fetch_assoc($n)) {
                                    $idk = $dn['id_kriteria'];


                                    //nilai kuadrat

                                    $nilai_kuadrat = 0;
                                    $k = mysqli_query($conn, "select * from nilai_matrik where id_kriteria='$idk' order by id_matrik ASC ");
                                    while ($dkuadrat = mysqli_fetch_assoc($k)) {
                                        $nilai_kuadrat = $nilai_kuadrat + ($dkuadrat['nilai'] * $dkuadrat['nilai']);
                                    }

                                    //hitung jml alternatif
                                    $jml_alternatif = mysqli_query($conn, "select * from alternatif order by id_alternatif asc;");

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

                                    $ymin[$c] = $v;
                                    $c++;
                                    $min = max($ymin);
                                }
                                //hitung D+
                                foreach ($ymin as $nymin => $value) {
                                    $mins = $_SESSION['ymin'][$nymin];
                                    //	echo $mins." - ";
                                    $final = sqrt($jarakp = $jarakp + pow($value - $mins, 2));
                                    //	echo $jarakp." || ";

                                }

                                echo "<tr>
		<td>$i</td>
		<td>$da[nm_alternatif]</td>
		<td>" . round($final, 4) . "</td>
		</tr>";
                                //session min
                                $dpreferensi[$ii] = round($final, 4);
                                $_SESSION['dmin'] = $dpreferensi;
                                // print_r($ymin);

                                //ambil id alternatif
                                $id_alt[$ii] = $da['id_alternatif'];
                                $_SESSION['id_alt'] = $id_alt;

                                $i++;
                                $ii++;
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
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>