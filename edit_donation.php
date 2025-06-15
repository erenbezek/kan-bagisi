<?php
session_start();
include('../includes/config.php');

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$donation_id = $_GET['id'];

// Kaydı çek
$stmt = $conn->prepare("SELECT blood_type, donation_date, location, note FROM donations WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $donation_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Kayıt bulunamadı.";
    exit;
}
$data = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $blood_type = $_POST['blood_type'];
    $donation_date = $_POST['donation_date'];
    $location = htmlspecialchars($_POST['location']);
    $note = htmlspecialchars($_POST['note']);

    $update = $conn->prepare("UPDATE donations SET blood_type=?, donation_date=?, location=?, note=? WHERE id=? AND user_id=?");
    $update->bind_param("ssssii", $blood_type, $donation_date, $location, $note, $donation_id, $user_id);

    if ($update->execute()) {
        header("Location: view_donations.php");
        exit;
    } else {
        $error = "Güncelleme başarısız.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Bağışı Düzenle</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Bağışı Güncelle</h2>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="post">
        <div class="mb-3">
            <label>Kan Grubu</label>
            <select name="blood_type" class="form-select" required>
                <?php
                $bloods = ["A+", "A-", "B+", "B-", "AB+", "AB-", "0+", "0-"];
                foreach ($bloods as $b) {
                    $sel = ($b == $data['blood_type']) ? "selected" : "";
                    echo "<option value='$b' $sel>$b</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Bağış Tarihi</label>
            <input type="date" name="donation_date" class="form-control" value="<?= $data['donation_date'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Konum</label>
            <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($data['location']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Not</label>
            <textarea name="note" class="form-control"><?= htmlspecialchars($data['note']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-success">Güncelle</button>
        <a href="view_donations.php" class="btn btn-secondary">İptal</a>
    </form>
</body>
</html>
