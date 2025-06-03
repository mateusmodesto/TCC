<?php
    session_start();
    session_unset();
    session_destroy();
    header('Location:/TCC-main/php/login.php');
    exit;
?>