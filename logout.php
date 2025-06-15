<?php
session_start();
session_unset(); // Tüm oturum değişkenlerini temizle
session_destroy(); // Oturumu tamamen sonlandır
header("Location: login.php"); // Giriş sayfasına yönlendir
exit;
