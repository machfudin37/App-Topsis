<?php
include("koneksi.php");
$s = mysqli_query($conn, "delete from kriteria where id_kriteria='$_GET[id]'");

if ($s && mysqli_affected_rows($conn) > 0) {
    echo '<script>alert("Kriteria berhasil dihapus"); window.open("kriteria.php", "_self");</script>';
} else {
    echo '<script>alert("Kriteria gagal dihapus"); window.history.back();</script>';
}