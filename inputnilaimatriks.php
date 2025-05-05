<?php
//inisialisasi session
session_start();
//mengecek username pada session
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = 'anda harus login untuk mengakses halaman ini';
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Input Nilai Matriks | App-Topsis</title>
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
                <div class="card-header"><strong>Input Nilai Matriks</strong></div>
                <div class="card-body">
                    <a href="import_excel_matriks.php" class="btn btn-secondary">Import Excel</a>
                    <div class="container-lg px-4">
                        <br>
                        <form action="" method="POST">
                            <div class="mb-3 row">
                                <label for="alternatif" class="col-sm-2 col-form-label">Alternatif</label>
                                <div class="col-sm-10">
                                    <select name="id_alt" class="form-control">
                                        <?php
                                        include("koneksi.php");
                                        $s = mysqli_query($conn, "SELECT * FROM alternatif ORDER BY CAST(SUBSTRING(id_alternatif FROM 2) AS UNSIGNED) ASC");
                                        while ($d = mysqli_fetch_assoc($s)) {
                                        ?>

                                        <option value="<?php echo $d['id_alternatif']; ?>">
                                            <?php echo $d['id_alternatif'] . ' | ' . $d['nm_alternatif']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <br>
                                </div>
                                <div class="mb-3 row">
                                    <?php
                                    $i = 1;
                                    $alt = mysqli_query($conn, "select * from kriteria");
                                    //hitung jml kriteria		
                                    $jml_krit = mysqli_num_rows($alt);
                                    while ($dalt = mysqli_fetch_assoc($alt)) {
                                    ?>
                                    <label for="alternatif"
                                        class="col-sm-2 col-form-label"><?php echo $dalt['nama_kriteria']; ?></label>
                                    <input type="hidden" name="id_krite<?php echo $i; ?>"
                                        value="<?php echo $dalt['id_kriteria']; ?>" />
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nilai<?php echo $i; ?>">
                                    </div>
                                    <?php
                                        $i++;
                                    }
                                    ?>
                                    <div class="col-6 mb-2">
                                        <br>
                                        <input class="btn btn-block btn-success" type="submit" name="simpan"
                                            value="Simpan">
                                    </div>
                                </div>
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
<?php
$b = mysqli_query($conn, 'select * from kriteria');
$c = mysqli_fetch_assoc($b);

//untuk tombol simpan
if (isset($_POST['simpan'])) {
    $o = 1;

    //cek id alternatif
    $id_alt = $_POST['id_alt'];
    $cek = mysqli_query($conn, "select * from alternatif where id_alternatif='$id_alt'");
    $cek_l = mysqli_num_rows($cek);
    if ($cek_l > 0) {
        $del = mysqli_query($conn, "delete from nilai_matrik where id_alternatif='$id_alt'");
    }

    for ($n = 1; $n <= $jml_krit; $n++) {
        $id_k = $_POST['id_krite' . $o];
        $nilai_k = $_POST['nilai' . $o];

        $m = mysqli_query($conn, "insert into nilai_matrik (id_alternatif,id_kriteria,nilai) values('$_POST[id_alt]','$id_k','$nilai_k')");

        $o++;
    }
    if ($m && mysqli_affected_rows($conn) > 0) {
        echo '<script>alert("Matrik Berhasil di simpan");</script>';
    } else {
        echo '<script>alert("Matrik Gagal di simpan"); window.history.back();</script>';
    }
}
?>