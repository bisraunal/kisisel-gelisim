# 🤖 AI.md – Yapay Zeka ile Geliştirme Günlüğü

Bu belge, **Kişisel Gelişim Hedef Takip Sistemi** adlı PHP & MySQL temelli projeyi geliştirirken yapay zeka (ChatGPT) ile gerçekleştirilen konuşmalardan alınan kod örnekleri ve yönlendirmeleri içermektedir.

---

## 🔒 1. Kullanıcı Kayıt & Şifre Hashleme

**Soru:** PHP ile kullanıcı kayıt sistemi yapacağım. Şifreleri nasıl güvenli saklayabilirim?

**Cevap:**
```php
$sifre = $_POST['sifre'];
$hashli_sifre = password_hash($sifre, PASSWORD_DEFAULT);

$sql = "INSERT INTO kullanicilar (kullanici_adi, sifre) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $kullanici_adi, $hashli_sifre);
$stmt->execute();
```

---

## 🔓 2. Kullanıcı Giriş & Oturum Açma

**Soru:** Giriş yapan kullanıcının oturumunu nasıl başlatırım?

**Cevap:**
```php
session_start();
$sql = "SELECT * FROM kullanicilar WHERE kullanici_adi=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $kullanici_adi);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (password_verify($sifre, $row['sifre'])) {
    $_SESSION['kullanici_id'] = $row['id'];
    header("Location: dashboard.php");
}
```

---

## 📁 3. Proje Klasör Yapısı

**Soru:** Dosyaları düzenli tutmak için nasıl bir yapıya sahip olmalıyım?

**Cevap:**
```
/kisisel_gelisim/
├── index.php
├── login.php
├── register.php
├── logout.php
├── hedef_ekle.php
├── hedef_duzenle.php
├── hedef_sil.php
├── dashboard.php
├── config.php
├── README.md
├── AI.md
├── /assets/
│   ├── /css/
│   └── /js/
├── /gorseller/
└── veritabani.sql
```

---

## 📥 4. Hedef Ekleme (CREATE)

**Soru:** Kullanıcının hedef girmesini sağlayan bir form ve PHP kodu nasıl yazılır?

**Cevap:**
```html
<form action="hedef_ekle.php" method="post">
  <input type="text" name="hedef_ad" required>
  <textarea name="aciklama"></textarea>
  <button type="submit">Ekle</button>
</form>
```

```php
session_start();
include 'config.php';

$hedef = $_POST["hedef_ad"];
$aciklama = $_POST["aciklama"];
$kullanici_id = $_SESSION["kullanici_id"];

$sql = "INSERT INTO hedefler (hedef_ad, aciklama, kullanici_id) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $hedef, $aciklama, $kullanici_id);
$stmt->execute();
```

---

## 📄 5. Hedef Listeleme (READ)

**Soru:** Kullanıcının hedeflerini tablo halinde nasıl listelerim?

**Cevap:**
```php
session_start();
include 'config.php';

$sql = "SELECT * FROM hedefler WHERE kullanici_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION["kullanici_id"]);
$stmt->execute();
$result = $stmt->get_result();

echo "<table>";
while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['hedef_ad']}</td><td>{$row['aciklama']}</td></tr>";
}
echo "</table>";
```

---

## 📝 6. Hedef Güncelleme (UPDATE)

**Soru:** Bir hedefin içeriğini düzenlemek için formu ve işlemi nasıl yaparım?

**Cevap:**
```php
// hedef_duzenle.php
session_start();
include 'config.php';

$id = $_GET['id'];
$sql = "SELECT * FROM hedefler WHERE id=? AND kullanici_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $_SESSION['kullanici_id']);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
```

```html
<form action="hedef_guncelle.php?id=<?php echo $id; ?>" method="post">
  <input type="text" name="hedef_ad" value="<?php echo $row['hedef_ad']; ?>">
  <textarea name="aciklama"><?php echo $row['aciklama']; ?></textarea>
  <button type="submit">Güncelle</button>
</form>
```

---

## ❌ 7. Hedef Silme (DELETE)

**Soru:** Hedefleri silerken güvenli sorgu nasıl yazarım?

**Cevap:**
```php
session_start();
include 'config.php';

$id = intval($_GET['id']);
$sql = "DELETE FROM hedefler WHERE id=? AND kullanici_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $_SESSION["kullanici_id"]);
$stmt->execute();
```

---

## 🎨 8. Bootstrap Kullanımı

**Soru:** Sayfalara Bootstrap stilini nasıl uygularım?

**Cevap:**
```html
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
```

---

## ⚙️ 9. config.php İçeriği

**Soru:** Bağlantı ayarlarını nasıl ortak bir dosyada tutarım?

**Cevap:**
```php
<?php
$conn = new mysqli("localhost", "root", "", "kisisel_gelisim");
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}
?>
```

---

## 🚪 10. Oturumu Kapatma

**Soru:** Kullanıcı sistemden nasıl çıkış yapar?

**Cevap:**
```php
session_start();
session_destroy();
header("Location: login.php");
```

---

## 🧾 11. Form Boşluk Kontrolleri

**Soru:** Boş form gönderilmesini nasıl engellerim?

**Cevap:**
```php
if (empty($_POST["hedef_ad"])) {
    echo "Lütfen hedef adı giriniz.";
    exit;
}
```

---

## 🧠 12. Hedefleri Tarihe Göre Sıralama

**Soru:** Hedefleri tarihe göre sıralamak istiyorum.

**Cevap:**
```php
$sql = "SELECT * FROM hedefler WHERE kullanici_id = ? ORDER BY olusturma_tarihi DESC";
```

---

## 📦 13. README.md İçeriği Nasıl Olmalı?

**Soru:** README.md dosyasında neler yer almalı?

**Cevap:**
- Proje adı ve açıklaması  
- Kullanılan teknolojiler  
- Kurulum adımları  
- Ekran görüntüleri  
- Uygulama videosu bağlantısı  
- Geliştirici adı

---


#
