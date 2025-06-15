<?php
session_start();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kişisel Gelişim Takip Sistemi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Özel CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="bg-light">

    <div class="container text-center mt-5">
        <h1 class="mb-4">📘 Kişisel Gelişim Hedef Takip Sistemi</h1>

        <?php if (isset($_SESSION['kullanici_id'])): ?>
            <p class="fs-5">Hoş geldiniz, başarılı şekilde giriş yaptınız.</p>
            <a href="dashboard.php" class="btn btn-primary me-2">Panele Git</a>
            <a href="logout.php" class="btn btn-danger"> Çıkış</a>
        <?php else: ?>
            <p class="fs-5">Devam etmek için lütfen giriş yapın veya kayıt olun.</p>
            <a href="login.php" class="btn btn-success me-2"> Giriş </a>
            <a href="register.php" class="btn btn-outline-primary">Kayıt Ol</a>
        <?php endif; ?>
    </div>

</body>
</html>
