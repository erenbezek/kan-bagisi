<?php
session_start();
include('includes/config.php');

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$donation_id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM donations WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $donation_id, $user_id);
$stmt->execute();
$stmt->close();

header("Location: view_donations.php");
exit;
?>