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
                <h3 class="box-title">Input Data Nilai Matriks</h3>
                <br>
            </div>
            <div class="table-responsive">
                <form method="POST" action="">
                    <div class="form-group">
                        <label class="control-label col-lg-2">Id Alternatif</label>
                        <div class="col-lg-4">
                            <select name="id_alt" class="form-control">
                                <?php
                                include("koneksi.php");
                                $s = mysqli_query($conn, "select * from alternatif");
                                while ($d = mysqli_fetch_assoc($s)) {
                                ?>

                                    <option value="<?php echo $d['id_alternatif'] ?>"><?php echo $d['id_alternatif'] . " | " . $d['nm_alternatif'] ?></option>
                                <?php
                                }
                                ?>
                            </select>


                        </div>

                    </div>
                    <br />
                    <hr />

                    <div class="form-group">
                        <?php
                        $i = 1;
                        $alt = mysqli_query($conn, "select * from kriteria");
                        //hitung jml kriteria		
                        $jml_krit = mysqli_num_rows($alt);

                        while ($dalt = mysqli_fetch_assoc($alt)) {
                        ?>

                            <table align="left">
                                <tr>
                                    <td width="200">
                                        <label><?php echo $dalt['nama_kriteria']; ?></label>
                                        <input type="hidden" name="id_krite<?php echo $i; ?>" value="<?php echo $dalt['id_kriteria']; ?>" />
                                    </td>
                                    <div class="col-md-8">
                                        <td width="80">
                                            <input type="radio" name="nilai<?php echo $i; ?>" value="<?php echo $dalt['poin1']; ?>" /><?php echo $dalt['poin1']; ?>
                                        </td>
                                        <td width="80">
                                            <input type="radio" name="nilai<?php echo $i; ?>" value="<?php echo $dalt['poin2']; ?>" /><?php echo $dalt['poin2']; ?>
                                        </td>
                                        <td width="80">
                                            <input type="radio" name="nilai<?php echo $i; ?>" value="<?php echo $dalt['poin3']; ?>" /><?php echo $dalt['poin3']; ?>
                                        </td>
                                        <td width="80">
                                            <input type="radio" name="nilai<?php echo $i; ?>" value="<?php echo $dalt['poin4']; ?>" /><?php echo $dalt['poin4']; ?>
                                        </td>
                                        <td width="80">
                                            <input type="radio" name="nilai<?php echo $i; ?>" value="<?php echo $dalt['poin5']; ?>" /><?php echo $dalt['poin5']; ?>
                                        </td>
                                </tr>

                            <?php
                            $i++;
                        }
                            ?>
                            <tr>
                                <td colspan=5 align="right">
                                    <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
                                </td>
                            </tr>
                            </table>

                    </div>

            </div>


            </form>
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
<?php
$b = mysqli_query($conn, "select * from kriteria");
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

        if ($m) {
            // echo "OK <br>";
        }

        $o++;
    }
}
?>