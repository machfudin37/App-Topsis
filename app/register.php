<?php
//menyertakan file program koneksi.php pada register
require 'koneksi.php';
//inisialisasi session
session_start();
$error = '';
$validate = '';
//mengecek apakah form registrasi di submit atau tidak
if (isset($_POST['submit'])) {
    // menghilangkan backshlases
    $username = stripslashes($_POST['username']);
    //cara sederhana mengamankan dari sql injection
    $username = mysqli_real_escape_string($conn, $username);
    $name = stripslashes($_POST['name']);
    $name = mysqli_real_escape_string($conn, $name);
    $email = stripslashes($_POST['email']);
    $email = mysqli_real_escape_string($conn, $email);
    $password = stripslashes($_POST['password']);
    $password = mysqli_real_escape_string($conn, $password);
    $repass = stripslashes($_POST['repassword']);
    $repass = mysqli_real_escape_string($conn, $repass);
    //cek apakah nilai yang diinputkan pada form ada yang kosong atau tidak
    if (!empty(trim($name)) && !empty(trim($username)) && !empty(trim($email)) && !empty(trim($password)) && !empty(trim($repass))) {
        //mengecek apakah password yang diinputkan sama dengan re-password yang diinputkan kembali
        if ($password == $repass) {
            //memanggil method cek_nama untuk mengecek apakah user sudah terdaftar atau belum
            if (cek_nama($name, $conn) == 0) {
                //hashing password sebelum disimpan didatabase
                $pass = password_hash($password, PASSWORD_DEFAULT);
                //insert data ke database
                $query = "INSERT INTO users (username,name,email, password ) VALUES ('$username','$nama','$email','$pass')";
                $result = mysqli_query($conn, $query);
                //jika insert data berhasil maka akan diredirect ke halaman index.php serta menyimpan data username ke session
                if ($result) {
                    $_SESSION['username'] = $username;

                    header('Location: index.php');

                    //jika gagal maka akan menampilkan pesan error
                } else {
                    $error = 'Register User Gagal !!';
                }
            } else {
                $error = 'Username sudah terdaftar !!';
            }
        } else {
            $validate = 'Password tidak sama !!';
        }
    } else {
        $error = 'Data tidak boleh kosong !!';
    }
}
//fungsi untuk mengecek username apakah sudah terdaftar atau belum
function cek_nama($username, $conn)
{
    $nama = mysqli_real_escape_string($conn, $username);
    $query = "SELECT * FROM users WHERE username = '$nama'";
    if ($result = mysqli_query($conn, $query)) {
        return mysqli_num_rows($result);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Daftar | App-Topsis</title>
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
    <!-- Main styles for this application-->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- We use those styles to show code examples, you should remove them in your application.-->
    <link href="assets/css/examples.css" rel="stylesheet">
    <!-- We use those styles to style Carbon ads and CoreUI PRO banner, you should remove them in your application.-->
    <link href="assets/css/ads.css" rel="stylesheet">
    <script src="assets/js/config.js"></script>
    <script src="assets/js/color-modes.js"></script>
</head>

<body>
    <div class="bg-body-tertiary min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mb-4 mx-4">
                        <div class="card-body p-4">
                            <h1>Register</h1>
                            <form action="register.php" method="POST">
                                <?php if ($error != '') { ?>
                                <div class="alert alert-danger" role="alert"><?= $error ?></div>
                                <?php } ?>
                                <p class="text-body-secondary">Create your account</p>
                                <div class="input-group mb-3"><span class="input-group-text">
                                        <svg class="icon">
                                            <use xlink:href="assets/vendors/@coreui/icons/svg/free.svg#cil-user"></use>

                                        </svg></span>
                                    <input class="form-control" name="name" id="name" type="text"
                                        placeholder="Masukan Nama">
                                </div>
                                <div class="input-group mb-3"><span class="input-group-text">
                                        <svg class="icon">
                                            <use
                                                xlink:href="assets/vendors/@coreui/icons/svg/free.svg#cil-envelope-open">
                                            </use>
                                        </svg></span>
                                    <input class="form-control" name="email" id="InputEmail" type="email"
                                        placeholder="Masukan Email">
                                </div>
                                <div class="input-group mb-3"><span class="input-group-text">
                                        <svg class="icon">
                                            <use xlink:href="assets/vendors/@coreui/icons/svg/free.svg#cil-user"></use>

                                        </svg></span>
                                    <input class="form-control" name="username" id="username" type="text"
                                        placeholder="Masukan Username">
                                </div>
                                <div class="input-group mb-3"><span class="input-group-text">
                                        <svg class="icon">
                                            <use
                                                xlink:href="assets/vendors/@coreui/icons/svg/free.svg#cil-lock-locked">
                                            </use>
                                        </svg></span>
                                    <input class="form-control" name="password" id="InputPassword" type="password"
                                        placeholder="Masukan Password">
                                </div>
                                <?php if ($validate != '') { ?>
                                <p class="text-danger"><?= $validate ?></p>
                                <?php } ?>
                                <div class="input-group mb-4"><span class="input-group-text">
                                        <svg class="icon">
                                            <use
                                                xlink:href="assets/vendors/@coreui/icons/svg/free.svg#cil-lock-locked">
                                            </use>
                                        </svg></span>
                                    <input class="form-control" id="InputRePassword" name="repassword"
                                        type="password" placeholder="Masukan Password Ulang">
                                </div>
                                <?php if ($validate != '') { ?>
                                <p class="text-danger"><?= $validate ?></p>
                                <?php } ?>
                                <div class="col-6 mb-2">
                                    <button class="btn btn-block btn-success" type="submit" name="submit">Create
                                        Account</button>
                                </div>
                                <p class="text-body-secondary">Sudah Punya akun? <a href="login.php">
                                        <button type="button" class="btn btn-primary px-4">Login</button></a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    <script></script>

</body>

</html>
