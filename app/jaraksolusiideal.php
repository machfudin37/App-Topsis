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
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Jarak Solusi Ideal | App-Topsis</title>
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
                <div class="card-header"><strong>Jarak Solusi Ideal</strong></div>
                <div class="card-body">
                    <strong>Jarak Solusi Ideal Positif (D<sup>+</sup>)</strong>
                    <div class="example">
                        <div class="tab-content rounded-bottom">
                            <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1005">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                <center>Kode</center>
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
                                        $a2 = mysqli_query($conn, "SELECT * FROM kriteria ORDER BY CAST(SUBSTRING(id_kriteria FROM 2) AS UNSIGNED) ASC");
                                        echo "<tr>";
                                        while ($da2 = mysqli_fetch_assoc($a2)) {

                                            $idalt2 = $da2['id_kriteria'];

                                            //ambil nilai
                                            $n2 = mysqli_query($conn, "SELECT * FROM nilai_matrik WHERE id_kriteria='$idalt2' ORDER BY CAST(SUBSTRING(id_matrik FROM 2) AS UNSIGNED) ASC");
                                            $jarakp2 = 0;
                                            $c2 = 0;
                                            $ymax2 = array();

                                            while ($dn2 = mysqli_fetch_assoc($n2)) {
                                                $idk2 = $dn2['id_kriteria'];

                                                //nilai kuadrat

                                                $nilai_kuadrat2 = 0;
                                                $k2 = mysqli_query($conn, "SELECT * FROM nilai_matrik WHERE id_kriteria='$idk2' ORDER BY CAST(SUBSTRING(id_matrik FROM 2) AS UNSIGNED) ASC");
                                                while ($dkuadrat2 = mysqli_fetch_assoc($k2)) {
                                                    $nilai_kuadrat2 = $nilai_kuadrat2 + ($dkuadrat2['nilai'] * $dkuadrat2['nilai']);
                                                }
                                                $akar_kuadrat = sqrt($nilai_kuadrat2);
                                                $nilai_matrik_ternormalisasi = number_format($dn2['nilai'] / $akar_kuadrat, 4);

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


                                                $v2 = number_format($nilai_matrik_ternormalisasi * $bot2, 4);

                                                $ymax2[$c2] = $v2;
                                                $c2++;

                                                #cek benefit atau cost  
                                                // echo $nbot2['jenis']." - ".$nbot2['nama_kriteria']."<br>";


                                                if ($nbot2['jenis'] == 'benefit') {
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

                                        //array baris//////////////////////////////////////////////////
                                        $i = 1;
                                        $ii = 0;
                                        $dpreferensi = array();
                                        $a = mysqli_query($conn, "SELECT * FROM alternatif ORDER BY CAST(SUBSTRING(id_alternatif FROM 2) AS UNSIGNED) ASC");
                                        echo "<tr>";
                                        while ($da = mysqli_fetch_assoc($a)) {

                                            $idalt = $da['id_alternatif'];

                                            //ambil nilai
                                            $n = mysqli_query($conn, "SELECT * FROM nilai_matrik WHERE id_alternatif='$idalt' ORDER BY CAST(SUBSTRING(id_matrik FROM 2) AS UNSIGNED) ASC");
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
                                                $akar_kuadrat = sqrt($nilai_kuadrat);
                                                $nilai_matrik_ternormalisasi = number_format($dn['nilai'] / $akar_kuadrat, 4);

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

                                                $v = number_format($nilai_matrik_ternormalisasi * $bot, 4);

                                                $ymax[$c] = $v;
                                                $c++;
                                                $mak = max($ymax);
                                            }
                                            //hitung D+ 
                                            foreach ($ymax as $nymax => $value) {
                                                $maks = $_SESSION['ymax'][$nymax];
                                                //echo $maks." - ";

                                                //echo $value."| ";

                                                $final = sqrt($jarakp = $jarakp + pow($value - $maks, 2));
                                                //echo $jarakp." || ";
                                            }

                                            echo "<tr>
		<td><center>$idalt</center></td>
		<td><center>$da[nm_alternatif]</center></td>
		<td><center>" . number_format($final, 4) . "</center></td>
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <strong>Jarak Solusi Ideal Negatif (D<sup>-</sup>)</strong>
                    <div class="example">
                        <div class="tab-content rounded-bottom">
                            <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1005">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                <center>Kode</center>
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
                                            $n2 = mysqli_query($conn, "SELECT * FROM nilai_matrik WHERE id_kriteria='$idalt2' ORDER BY CAST(SUBSTRING(id_matrik FROM 2) AS UNSIGNED) ASC");
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
                                                $akar_kuadrat = sqrt($nilai_kuadrat2);
                                                $nilai_matrik_ternormalisasi = number_format($dn2['nilai'] / $akar_kuadrat, 4);
                                                $bobot2 = $tnilai2 / $jml_a2;

                                                //nilai bobot input
                                                $b2 = mysqli_query($conn, "select * from kriteria where id_kriteria='$idk2'");
                                                $nbot2 = mysqli_fetch_assoc($b2);
                                                $bot2 = $nbot2['bobot'];

                                                $v2 = number_format($nilai_matrik_ternormalisasi * $bot2, 4);

                                                $ymin2[$c2] = $v2;
                                                $c2++;

                                                #cek benefit atau cost
                                                if ($nbot2['jenis'] == 'cost') {
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
                                        $a = mysqli_query($conn, "SELECT * FROM alternatif ORDER BY CAST(SUBSTRING(id_alternatif FROM 2) AS UNSIGNED) ASC");
                                        echo "<tr>";
                                        while ($da = mysqli_fetch_assoc($a)) {

                                            $idalt = $da['id_alternatif'];

                                            //ambil nilai
                                            $n = mysqli_query($conn, "SELECT * FROM nilai_matrik WHERE id_alternatif='$idalt' ORDER BY CAST(SUBSTRING(id_matrik FROM 2) AS UNSIGNED) ASC");
                                            $jarakp = 0;
                                            $c = 0;
                                            $ymax = array();
                                            $arraymin = array();
                                            while ($dn = mysqli_fetch_assoc($n)) {
                                                $idk = $dn['id_kriteria'];


                                                //nilai kuadrat

                                                $nilai_kuadrat = 0;
                                                $k = mysqli_query($conn, "SELECT * FROM nilai_matrik WHERE id_kriteria='$idk' ORDER BY CAST(SUBSTRING(id_matrik FROM 2) AS UNSIGNED) ASC");
                                                while ($dkuadrat = mysqli_fetch_assoc($k)) {
                                                    $nilai_kuadrat = $nilai_kuadrat + ($dkuadrat['nilai'] * $dkuadrat['nilai']);
                                                }

                                                //hitung jml alternatif
                                                $jml_alternatif = mysqli_query($conn, "SELECT * FROM alternatif ORDER BY CAST(SUBSTRING(id_alternatif FROM 2) AS UNSIGNED) ASC");

                                                $jml_a = mysqli_num_rows($jml_alternatif);
                                                //nilai bobot kriteria (rata")
                                                $bobot = 0;
                                                $tnilai = 0;

                                                $k2 = mysqli_query($conn, "SELECT * FROM nilai_matrik WHERE id_kriteria='$idk' ORDER BY CAST(SUBSTRING(id_matrik FROM 2) AS UNSIGNED) ASC");
                                                while ($dbobot = mysqli_fetch_assoc($k2)) {
                                                    $tnilai = $tnilai + $dbobot['nilai'];
                                                }
                                                $akar_kuadrat = sqrt($nilai_kuadrat);
                                                $nilai_matrik_ternormalisasi = number_format($dn['nilai'] / $akar_kuadrat, 4);
                                                $bobot = $tnilai / $jml_a;

                                                //nilai bobot input
                                                $b2 = mysqli_query($conn, "select * from kriteria where id_kriteria='$idk'");
                                                $nbot = mysqli_fetch_assoc($b2);
                                                $bot = $nbot['bobot'];

                                                $v = number_format($nilai_matrik_ternormalisasi * $bot, 4);

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
		<td><center>$idalt</center></td>
		<td><center>$da[nm_alternatif]</center></td>
		<td><center>" . number_format($final, 4) . "</center></td>
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