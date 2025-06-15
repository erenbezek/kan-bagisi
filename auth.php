<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Oturum yoksa login sayfasına yönlendir
    header("Location: login.php");
    exit;
}
