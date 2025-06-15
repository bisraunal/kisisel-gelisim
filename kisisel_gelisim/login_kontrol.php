<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $sifre = $_POST['sifre'] ?? '';

    $stmt = $mysqli->prepare("SELECT id, sifre FROM kullanicilar WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hashli_sifre);
        $stmt->fetch();

        if (password_verify($sifre, $hashli_sifre)) {
            $_SESSION['kullanici_id'] = $id;
            header("Location: dashboard.php");
            exit();
        } else {
            header("Location: login.php?hata=Şifre yanlış.");
            exit();
        }
    } else {
        header("Location: login.php?hata=Kullanıcı bulunamadı.");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>
