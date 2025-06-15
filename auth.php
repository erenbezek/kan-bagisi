<?php
session_start();
include('includes/config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>