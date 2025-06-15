<?php
session_start();
include('../includes/config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT id, blood_type, donation_date, location, note FROM donations WHERE user_id = ? ORDER BY donation_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Bağış Listesi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Bağış Geçmişi</h2>
    <a href="dashboard.php" class="btn btn-secondary mb-3">← Geri Dön</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tarih</th>
                <th>Kan Grubu</th>
                <th>Konum</th>
                <th>Not</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['donation_date']) ?></td>
                    <td><?= htmlspecialchars($row['blood_type']) ?></td>
                    <td><?= htmlspecialchars($row['location']) ?></td>
                    <td><?= nl2br(htmlspecialchars($row['note'])) ?></td>
                    <td>
                        <a href="edit_donation.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Düzenle</a>
                        <a href="delete_donation.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bu bağışı silmek istediğinize emin misiniz?')">Sil</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
