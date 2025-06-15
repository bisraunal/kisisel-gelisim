<?php
session_start();
require 'config.php';

if (!isset($_SESSION['kullanici_id'])) {
    header("Location: login.php");
    exit();
}

$kullanici_id = $_SESSION['kullanici_id'];
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: dashboard.php");
    exit();
}

// Mevcut hedef verisini al
$stmt = $mysqli->prepare("SELECT baslik, aciklama, tarih, durum FROM hedefler WHERE id = ? AND kullanici_id = ?");
$stmt->bind_param("ii", $id, $kullanici_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows !== 1) {
    header("Location: dashboard.php");
    exit();
}

$hedef = $result->fetch_assoc();

$hata = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $baslik = trim($_POST['baslik']);
    $aciklama = trim($_POST['aciklama']);
    $tarih = $_POST['tarih'];
    $durum = $_POST['durum'];

    if ($baslik === '') {
        $hata = 'Başlık alanını doldurunuz.';
    } else {
        $stmt = $mysqli->prepare("UPDATE hedefler SET baslik = ?, aciklama = ?, tarih = ?, durum = ? WHERE id = ? AND kullanici_id = ?");
        $stmt->bind_param("ssssii", $baslik, $aciklama, $tarih, $durum, $id, $kullanici_id);
        $stmt->execute();
        header("Location: dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Hedef Düzenle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
<div class="container mt-5">
    <h2>Hedef Düzenle</h2>

    <?php if ($hata): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($hata); ?></div>
    <?php endif; ?>

    <form method="POST" action="hedef_duzenle.php?id=<?php echo $id; ?>">
        <input type="text" name="baslik" placeholder="Başlık" class="form-control mb-3" required value="<?php echo htmlspecialchars($hedef['baslik']); ?>" />
        <textarea name="aciklama" placeholder="Açıklama" class="form-control mb-3"><?php echo htmlspecialchars($hedef['aciklama']); ?></textarea>
        <input type="date" name="tarih" class="form-control mb-3" value="<?php echo htmlspecialchars($hedef['tarih']); ?>" />
        <select name="durum" class="form-select mb-3">
            <option value="Başlamadı" <?php if ($hedef['durum'] === 'Başlamadı') echo 'selected'; ?>>Başlamadı</option>
            <option value="Devam Ediyor" <?php if ($hedef['durum'] === 'Devam Ediyor') echo 'selected'; ?>>Devam Ediyor</option>
            <option value="Tamamlandı" <?php if ($hedef['durum'] === 'Tamamlandı') echo 'selected'; ?>>Tamamlandı</option>
        </select>
        <button type="submit" class="btn btn-primary">Güncelle</button>
        <a href="dashboard.php" class="btn btn-secondary ms-2">İptal</a>
    </form>
</div>
<script src="assets/js/script.js"></script>
</body>
</html>

