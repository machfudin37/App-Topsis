<?php
include("koneksi.php");

$s = mysqli_query($conn, "delete from alternatif where id_alternatif='$_GET[id]' ");

if ($s && mysqli_affected_rows($conn) > 0) {
    echo '<script>alert("Alternatif berhasil dihapus"); window.open("alternatif.php", "_self");</script>';
} else {
    echo '<script>alert("Alternatif gagal dihapus"); window.history.back();</script>';
}
?>
