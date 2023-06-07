<?php
include("koneksi.php");

$s = mysqli_query($conn, "delete from alternatif where id_alternatif='$_GET[id]' ");

if ($s) {
    echo "<script>window.open('alternatif.php','_self');</script>";
}
