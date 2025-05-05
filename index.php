<?php
//inisialisasi session
session_start();
//mengecek username pada session
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = 'anda harus login untuk mengakses halaman ini';
    header('Location: login.php');
}
?>
<html lang="en">

<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard | App-Topsis</title>
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
    <?php include 'layout/head.php' ?>
</head>

<body>
    <?php include 'layout/sidebar.php'; ?>
    <div class="wrapper d-flex flex-column min-vh-100">
        <?php include 'layout/header.php'; ?>
        <div class="body flex-grow-1">
            <div class="container-lg px-4">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <div class="col">
                        <a href="kriteria.php" style="text-decoration: none;">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Data Kriteria</h5>
                                    <p class="card-text">Halaman yang digunakan untuk memasukan Data Kriteria</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="alternatif.php" style="text-decoration: none;">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Data Alternatif</h5>
                                    <p class="card-text">Halaman yang digunakan untuk memasukan Data Alternatif</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="inputnilaimatriks.php" style="text-decoration: none;">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Input Nilai Matriks</h5>
                                    <p class="card-text">Halaman yang digunakan untuk memasukan Nilai Matriks</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="nilaimatriks.php" style="text-decoration: none;">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Nilai Matriks</h5>
                                    <p class="card-text">Halaman yang digunakan untuk menampilkan Nilai Matriks setiap
                                        Alternatif yang sudah dimasukan</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="nilaimatriksternormalisasi.php" style="text-decoration: none;">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Nilai Matriks Ternormalisasi</h5>
                                    <p class="card-text">Halaman yang digunakan untuk menampilkan Hasil Perhitungan dari
                                        Nilai Matriks Ternormalisasi</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="nilaibobotternormalisasi.php" style="text-decoration: none;">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Nilai Bobot Ternormalisasi</h5>
                                    <p class="card-text">Halaman yang digunakan untuk menampilkan Hasil Perhitungan dari
                                        Nilai Bobot Ternormalisasi</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="nilaiideal.php" style="text-decoration: none;">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Nilai Ideal</h5>
                                    <p class="card-text">Halaman yang digunakan untuk menampilkan Hasil Perhitungan
                                        Nilai Ideal Positif dan Negatif</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="jaraksolusiideal.php" style="text-decoration: none;">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Jarak Solusi Ideal </h5>
                                    <p class="card-text">Halaman yang digunakan untuk menampilkan Hasil Perhitungan
                                        Jarak Solusi Ideal Positif dan Negatif</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="nilaipreferensi.php" style="text-decoration: none;">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Nilai Preferensi </h5>
                                    <p class="card-text">Halaman yang digunakan untuk menampilkan Hasil Perhitungan
                                        Nilai Preferensi yang sudah diberikan ranking</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <br>
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