<?php
session_start();
require 'config.php';

if (!isset($_SESSION['kullanici_id'])) {
    header("Location: login.php");
    exit();
}

$kullanici_id = $_SESSION['kullanici_id'];

// Yeni hedef ekleme
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['baslik'])) {
    $baslik = trim($_POST['baslik']);
    $aciklama = trim($_POST['aciklama']);
    $tarih = $_POST['tarih'];
    $durum = $_POST['durum'];

    if ($baslik != '') {
        $stmt = $mysqli->prepare("INSERT INTO hedefler (kullanici_id, baslik, aciklama, tarih, durum) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $kullanici_id, $baslik, $aciklama, $tarih, $durum);
        $stmt->execute();
    }
    header("Location: dashboard.php");
    exit();
}

// Hedefleri çek
$stmt = $mysqli->prepare("SELECT id, baslik, aciklama, tarih, durum FROM hedefler WHERE kullanici_id = ? ORDER BY tarih DESC");
$stmt->bind_param("i", $kullanici_id);
$stmt->execute();
$result = $stmt->get_result();
$hedefler = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
<nav class="navbar">
    <div>
        <a href="dashboard.php">Anasayfa</a>
        <a href="logout.php" class="btn btn-sm btn-outline-danger">Çıkış Yap</a>
    </div>
</nav>

<div class="container mt-4">
    <h1 class="mb-4">Kişisel Gelişim Hedef Takip Sistemi</h1>

    <form method="POST" action="dashboard.php" class="mb-5">
        <h3>Yeni Hedef Ekle</h3>
        <input type="text" name="baslik" placeholder="Başlık" class="form-control mb-3" required />
        <textarea name="aciklama" placeholder="Açıklama" class="form-control mb-3"></textarea>
        <input type="date" name="tarih" class="form-control mb-3" />
        <select name="durum" class="form-select mb-3">
            <option value="Başlamadı" selected>Başlamadı</option>
            <option value="Devam Ediyor">Devam Ediyor</option>
            <option value="Tamamlandı">Tamamlandı</option>
        </select>
        <button type="submit" class="btn btn-primary">Kaydet</button>
    </form>

    <h3>Hedefleriniz</h3>
    <?php if (count($hedefler) === 0): ?>
        <p>Hedef hala eklenmedi, hedef ekleyebilirsiniz.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Başlık</th>
                    <th>Açıklama</th>
                    <th>Tarih</th>
                    <th>Durum</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hedefler as $h): ?>
                <tr>
                    <td><?php echo htmlspecialchars($h['baslik']); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($h['aciklama'])); ?></td>
                    <td><?php echo htmlspecialchars($h['tarih']); ?></td>
                    <td><?php echo htmlspecialchars($h['durum']); ?></td>
                    <td>
                        <a href="hedef_duzenle.php?id=<?php echo $h['id']; ?>" class="btn btn-sm btn-warning">Düzenle</a>
                        <a href="hedef_sil.php?id=<?php echo $h['id']; ?>" onclick="return confirm('Silmek istediğinize emin misiniz?');" class="btn btn-sm btn-danger">Sil</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<script src="assets/js/script.js"></script>
</body>
</html>
