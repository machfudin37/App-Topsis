<?php
include("koneksi.php");
$s = mysqli_query($conn, "delete from kriteria where id_kriteria='$_GET[id]'");

if ($s) {
    echo "<script>window.open('index.php','_self');</script>";
} else {
    echo $a = "delete from kriteria where id_kriteria='$_GET[id]'";
}
