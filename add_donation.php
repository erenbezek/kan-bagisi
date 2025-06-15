<?php
require_once 'auth.php';
session_start();
include('includes/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $blood_type = $_POST['blood_type'];
    $donation_date = $_POST['donation_date'];
    $location = htmlspecialchars($_POST['location']);
    $note = htmlspecialchars($_POST['note']);

    $stmt = $conn->prepare("INSERT INTO donations (user_id, blood_type, donation_date, location, note) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $blood_type, $donation_date, $location, $note);

    if ($stmt->execute()) {
        header("Location: view_donations.php");
        exit;
    } else {
        $error = "Kayıt basarisiz: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Bağış Ekle</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Yeni Kan Bağışı Ekle</h2>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="post">
        <div class="mb-3">
            <label>Kan Grubu</label>
            <select name="blood_type" class="form-select" required>
                <option value="">Seçiniz</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="0+">0+</option>
                <option value="0-">0-</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Bağış Tarihi</label>
            <input type="date" name="donation_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Konum</label>
            <input type="text" name="location" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Not (isteğe bağlı)</label>
            <textarea name="note" class="form-control" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Kaydet</button>
        <a href="dashboard.php" class="btn btn-secondary">Geri Dön</a>
    </form>
</body>
</html>