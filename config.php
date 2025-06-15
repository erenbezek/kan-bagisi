<?php
$host = "95."; // Hosting panelinden aldığınız host adı
$user = "your_username";       // Hosting panelinden aldığınız kullanıcı adı
$pass = "your_password";       // Hosting panelinden aldığınız şifre
$dbname = "your_database";     // Hosting panelinden aldığınız veritabanı adı

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Veritabani baglanti hatasi: " . $conn->connect_error);
}
?>