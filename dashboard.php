<?php
require_once 'auth.php'; // Oturum zaten auth.php'de başlatılıyor
include('includes/config.php');

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT name FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Panel - Gönüllü Kan Bagisi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Merhaba, <?= htmlspecialchars($name) ?> 👋</h2>
        <a href="logout.php" class="btn btn-danger">Cikis Yap</a>
    </div>

    <hr>

    <div class="list-group">
        <a href="add_donation.php" class="list-group-item list-group-item-action">➕ Yeni Kan Bagisi Ekle</a>
        <a href="view_donations.php" class="list-group-item list-group-item-action">📋 Bagis Gecmisini Goruntule</a>
    </div>
</body>
</html>