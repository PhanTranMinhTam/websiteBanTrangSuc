<?php
    session_start();
    unset($_SESSION['logged_user']);
    unset($_SESSION['logged_admin']);
    unset($_SESSION['id_user']);
    header("location: index.php");
    exit;