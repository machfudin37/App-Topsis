<?php
    session_start(); //inisialisasi session
    if(session_destroy()) {//menghapus session
        header("Location: kriteria.php"); //jika berhasil maka akan diredirect ke file kriteria.php
    }
?>