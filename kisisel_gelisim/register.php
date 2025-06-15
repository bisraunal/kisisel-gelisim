<?php
session_start();
require 'config.php';

$hata = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adsoyad = trim($_POST['adsoyad']);
    $email = trim($_POST['email']);
    $sifre = $_POST['sifre'];
    $sifre_tekrar = $_POST['sifre_tekrar'];

    if (empty($adsoyad) || empty($email) || empty($sifre) || empty($sifre_tekrar)) {
        $hata = "Tüm alanları doldurun.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $hata = "Geçerli bir e-posta girin.";
    } elseif ($sifre !== $sifre_tekrar) {
        $hata = "Şifreler uyuşmuyor.";
    } else {
        // E-posta zaten kayıtlı mı kontrolü
        $stmt = $mysqli->prepare("SELECT id FROM kullanicilar WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $hata = "Bu e-posta zaten kayıtlı.";
        } else {
            $hashli_sifre = password_hash($sifre, PASSWORD_DEFAULT);
            $stmt = $mysqli->prepare("INSERT INTO kullanicilar (adsoyad, email, sifre) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $adsoyad, $email, $hashli_sifre);
            if ($stmt->execute()) {
                header("Location: login.php?basarili=Kaydınız başarılı, giriş yapabilirsiniz.");
                exit();
            } else {
                $hata = "Kayıt sırasında hata oluştu.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Kayıt Ol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Kayıt Ol</h2>

        <?php if ($hata): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($hata); ?></div>
        <?php endif; ?>

        <form method="POST" action="register.php" novalidate>
            <input type="text" name="adsoyad" placeholder="Ad Soyad" class="form-control mb-3" required />
            <input type="email" name="email" placeholder="E-posta" class="form-control mb-3" required />

            <input type="password" name="sifre" placeholder="Şifre" class="form-control mb-3" required minlength="6" />
            <input type="password" name="sifre_tekrar" placeholder="Şifre Tekrar" class="form-control mb-3" required minlength="6" />
            <button type="submit" class="btn btn-primary w-100">Kayıt Ol</button>
        </form>

        <p class="text-center mt-3">Zaten hesabınız mı var? <a href="login.php">Giriş yap</a></p>
    </div>
    <script src="assets/js/script.js"></script>
</body>
</html>
