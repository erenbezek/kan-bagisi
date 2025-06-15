<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "kanbagisi";

$conn = new mysqli("localhost", "kullaniciadi", "sifre", "kanbagisi");

if ($conn->connect_error) {
    die("Veritabani bağlanti hatasi: " . $conn->connect_error);
}
?>
