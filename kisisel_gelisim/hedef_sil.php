<?php
session_start();
require 'config.php';

if (!isset($_SESSION['kullanici_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $kullanici_id = $_SESSION['kullanici_id'];

    // Hedef sadece kendi kullanıcısına ait mi kontrol et
    $stmt = $mysqli->prepare("DELETE FROM hedefler WHERE id = ? AND kullanici_id = ?");
    $stmt->bind_param("ii", $id, $kullanici_id);
    $stmt->execute();
}

header("Location: dashboard.php");
exit();
?>
