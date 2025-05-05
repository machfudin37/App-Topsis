<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "app-topsis";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah form telah di-submit
if (isset($_POST["simpan"])) {
    // Periksa apakah file telah diunggah
    if (isset($_FILES['excel_matriks']['tmp_name'])) {
        $file = $_FILES['excel_matriks']['tmp_name'];

        // Load library PHPExcel
        require_once 'PHPExcel/Classes/PHPExcel.php';

        $objReader = PHPExcel_IOFactory::createReaderForFile($file);
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($file);
        $objWorksheet = $objPHPExcel->getActiveSheet();

        // Loop melalui setiap baris data
        foreach ($objWorksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE);

            $data = array();
            foreach ($cellIterator as $cell) {
                $data[] = $cell->getValue();
            }

            // Simpan data ke database
            $sql = "INSERT INTO nilai_matrik (id_matrik, id_alternatif, id_kriteria, nilai) VALUES ('" . $data[0] . "', '" . $data[1] . "', '" . $data[2] . "', '" . $data[3] . "')";
            if ($conn->query($sql) !== TRUE) {
                echo '<script>alert("Excel berhasil diimport"); window.open("inputnilaimatriks.php", "_self");</script>';
            }
        }
    } else {
        echo "File tidak ditemukan.";
    }
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Import Excel Matriks | App-Topsis</title>
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
                <div class="card-header"><strong>Import Excel Matriks</strong></div>
                <div class="container-lg px-4">
                    <br>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="input-group mb-3">
                            <input class="form-control" name="excel_matriks" id="excel_matriks" type="file"
                                accept=".xls,.xlsx" required>
                        </div>
                        <div class="col-6 mb-2">
                            <input class="btn btn-block btn-success" type="submit" name="simpan" value="Simpan">
                            <a href="inputnilaimatriks.php" class="btn btn-block btn-primary">Kembali</a>
                        </div>
                    </form>
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