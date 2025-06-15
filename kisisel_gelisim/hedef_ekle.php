<?php
session_start();
if (!isset($_SESSION['kullanici_id'])) {
    header("Location: login.php");
    exit;
}
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $hedef_ad = trim($_POST["hedef_ad"]);
    $aciklama = trim($_POST["aciklama"]);
    $kullanici_id = $_SESSION['kullanici_id'];

    if (!empty($hedef_ad)) {
        $sql = "INSERT INTO hedefler (hedef_ad, aciklama, kullanici_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $hedef_ad, $aciklama, $kullanici_id);
        $stmt->execute();
        header("Location: dashboard.php");
        exit;
    } else {
        $hata = "Hedef adı boş olamaz.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hedef Ekleme</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h3>Yeni Hedef Oluşturma</h3>

    <?php if (isset($hata)): ?>
        <div class="alert alert-danger"><?= $hata ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Hedef ismi </label>
            <input type="text" name="hedef_ad" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Açıklama</label>
            <textarea name="aciklama" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Ekle</button>
        <a href="dashboard.php" class="btn btn-secondary">Geri</a>
    </form>
</body>
</html>
