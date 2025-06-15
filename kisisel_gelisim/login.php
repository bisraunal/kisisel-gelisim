<?php
session_start();
if (isset($_SESSION['kullanici_id'])) {
    header("Location: dashboard.php");
    exit();
}

$mesaj = '';
if (isset($_GET['hata'])) {
    $mesaj = $_GET['hata'];
} elseif (isset($_GET['basarili'])) {
    $mesaj = $_GET['basarili'];
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Giriş Yap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Giriş Yap</h2>

        <?php if ($mesaj): ?>
            <div class="alert alert-<?php echo strpos($mesaj, 'hata') !== false || strpos($mesaj, 'yanlış') !== false ? 'danger' : 'success'; ?>">
                <?php echo htmlspecialchars($mesaj); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="login_kontrol.php" novalidate>
            <input type="email" name="email" placeholder="E-posta" class="form-control mb-3" required />
            <input type="password" name="sifre" placeholder="Şifre" class="form-control mb-3" required />
            <button type="submit" class="btn btn-primary w-100">Giriş Yap</button>
        </form>

        <p class="text-center mt-3">Hesabınız yok mu? <a href="register.php">Kayıt olun</a></p>
    </div>
    <script src="assets/js/script.js"></script>
</body>
</html>
