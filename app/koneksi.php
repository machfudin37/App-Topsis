<?php

$server = "mysql";
$user = "user";
$pass = "pass";
$database = "app-topsis";

$conn = mysqli_connect($server, $user, $pass, $database);

if (!$conn) {
    die("<script>alert('Gagal tersambung dengan database.')</script>");
}
