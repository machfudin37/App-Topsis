<?php
//inisialisasi session
session_start();
//mengecek username pada session
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = 'anda harus login untuk mengakses halaman ini';
    header('Location: login.php');
}
include 'koneksi.php';
$s = mysqli_query($conn, 'select * from kriteria ');
$h = mysqli_num_rows($s);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Nilai Bobot Ternormalisasi | App-Topsis</title>
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
                <div class="card-header"><strong>Nilai Bobot Ternormalisasi</strong></div>
                <div class="card-body">
                    <div class="example">
                        <div class="tab-content rounded-bottom">
                            <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1005">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Kode</th>
                                            <th rowspan="2">Nama Kriteria</th>
                                            <th colspan="<?php echo $h; ?>">
                                                <center>
                                                    Kriteria
                                                </center>
                                            </th>
                                        </tr>
                                        <tr>
                                            <?php
                                            for ($n = 1; $n <= $h; $n++) {
                                                echo "<th><center>C{$n}</center></th>";
                                            }
                                            ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        $a = mysqli_query($conn, "SELECT * FROM alternatif ORDER BY CAST(SUBSTRING(id_alternatif FROM 2) AS UNSIGNED) ASC");

                                        while ($da = mysqli_fetch_assoc($a)) {
                                            echo "<tr>
            <td>{$da['id_alternatif']}</td>
            <td>{$da['nm_alternatif']}</td>";
                                            $idalt = $da['id_alternatif'];

                                            // Ambil nilai
                                            $n = mysqli_query($conn, "SELECT * FROM nilai_matrik WHERE id_alternatif='$idalt' ORDER BY id_matrik ASC");

                                            while ($dn = mysqli_fetch_assoc($n)) {
                                                $idk = $dn['id_kriteria'];

                                                // Nilai kuadrat
                                                $nilai_kuadrat = 0;
                                                $k = mysqli_query($conn, "SELECT * FROM nilai_matrik WHERE id_kriteria='$idk'");
                                                while ($dkuadrat = mysqli_fetch_assoc($k)) {
                                                    $nilai_kuadrat += $dkuadrat['nilai'] * $dkuadrat['nilai'];
                                                }
                                                $akar_kuadrat = sqrt($nilai_kuadrat);
                                                $nilai_matrik_ternormalisasi = number_format($dn['nilai'] / $akar_kuadrat, 4);
                                                // Hitung jumlah alternatif
                                                $jml_alternatif = mysqli_query($conn, "SELECT * FROM alternatif");
                                                $jml_a = mysqli_num_rows($jml_alternatif);

                                                //nilai bobot kriteria (rata")
                                                $bobot = 0;
                                                $tnilai = 0;

                                                $k2 = mysqli_query($conn, "select * from nilai_matrik where id_kriteria='$idk' ");
                                                while ($dbobot = mysqli_fetch_assoc($k2)) {
                                                    $tnilai = $tnilai + $dbobot['nilai'];
                                                }
                                                $bobot = $tnilai / $jml_a;

                                                // Nilai bobot input
                                                $b2 = mysqli_query($conn, "SELECT * FROM kriteria WHERE id_kriteria='$idk' ORDER BY id_kriteria ASC");
                                                if ($b2 && mysqli_num_rows($b2) > 0) {
                                                    $nbot = mysqli_fetch_assoc($b2);
                                                    $bot = $nbot['bobot'];
                                                    $nilai_bobot_ternormalisasi = number_format($nilai_matrik_ternormalisasi * $bot, 4);
                                                    echo "<td align='center'>{$nilai_bobot_ternormalisasi}</td>";
                                                } else {
                                                    echo "<td align='center'>N/A</td>"; // Tampilkan N/A jika tidak ada data kriteria
                                                }
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