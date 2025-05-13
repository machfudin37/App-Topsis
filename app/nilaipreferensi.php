<?php
//inisialisasi session
session_start();
//mengecek username pada session
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = 'anda harus login untuk mengakses halaman ini';
    header('Location: login.php');
}
include("koneksi.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Nilai Preferensi | App-Topsis</title>
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
                <div class="card-header"><strong>Nilai Preferensi</strong></div>
                <div class="card-body">
                    <div class="example">
                        <div class="tab-content rounded-bottom">
                            <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1005">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                <center>Rank</center>
                                            </th>
                                            <th>
                                                <center>Kode</center>
                                            </th>
                                            <th>
                                                <center>Nama</center>
                                            </th>
                                            <th>
                                                <center>V<sub>i</sub></center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $a = mysqli_query($conn, "SELECT * FROM alternatif ORDER BY CAST(SUBSTRING(id_alternatif FROM 2) AS UNSIGNED) ASC");
                                        echo "<tr>";
                                        $sortir = array();
                                        while ($da = mysqli_fetch_assoc($a)) {



                                            $idalt = $da['id_alternatif'];

                                            //ambil nilai

                                            $n = mysqli_query($conn, "select * from nilai_matrik where id_alternatif='$idalt' order by id_matrik ASC");

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
                                                $akar_kuadrat = sqrt($nilai_kuadrat);
                                                $nilai_matrik_ternormalisasi = number_format($dn['nilai'] / $akar_kuadrat, 4);

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
                                                $bobot = $tnilai / $jml_a;

                                                //nilai bobot input
                                                $b2 = mysqli_query($conn, "select * from kriteria where id_kriteria='$idk'");
                                                $nbot = mysqli_fetch_assoc($b2);
                                                $bot = $nbot['bobot'];

                                                $v = number_format($nilai_matrik_ternormalisasi * $bot, 4);

                                                $ymax[$c] = $v;
                                                $c;
                                                $mak = max($ymax);
                                                $min = min($ymax);
                                            }

                                            $i++;
                                        }




                                        foreach (@$_SESSION['dplus'] as $key => $dxmin) {
                                            #ubah ke nol hasil akhir
                                            $nilaid = 0;
                                            $nilaiPre = 0;
                                            $nilai = 0;

                                            $jarakm = $_SESSION['dmin'][$key];
                                            $id_alt = $_SESSION['id_alt'][$key];

                                            //nama alternatif
                                            $nama = mysqli_query($conn, "select * from alternatif where id_alternatif='$id_alt'");
                                            $nm = mysqli_fetch_assoc($nama);


                                            $nilaiPre = $dxmin + $jarakm;

                                            $nilaid = $jarakm / $nilaiPre;


                                            $nilai = round($nilaid, 4);

                                            //simpan ke tabel nilai preferensi
                                            $nm = $nm['nm_alternatif'];

                                            $sql2 = mysqli_query($conn, "insert into nilai_preferensi (nm_alternatif,nilai,id_alternatif) values('$nm','$nilai','$id_alt')");
                                        }

                                        //ambil data sesuai dengan nilai tertinggi
                                        $i = 1;
                                        $sql3 = mysqli_query($conn, "select * from nilai_preferensi  order by nilai desc");
                                        $nilai_kriteria = mysqli_query($conn, "SELECT * FROM nilai_preferensi ORDER BY nilai DESC");
                                        while ($data3 = mysqli_fetch_assoc($sql3)) {
                                            echo "<tr>
		<td><center>" . $i . "</center></td>
		<td><center>$data3[id_alternatif]</center></td>
		<td><center>$data3[nm_alternatif]</center></td>
		<td><center>$data3[nilai]</center></td>
		</tr>";

                                            $i++;
                                        }


                                        // //kosongkan tabel nilai preferensi
                                        $del = mysqli_query($conn, "delete from nilai_preferensi");

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