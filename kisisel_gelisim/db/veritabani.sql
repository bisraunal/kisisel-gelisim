-- Veritabanı oluşturma (önce bu komutu çalıştır)
CREATE DATABASE IF NOT EXISTS kisisel_gelisim;
USE kisisel_gelisim;

-- Kullanıcılar tablosu
CREATE TABLE kullanicilar (
    id INT AUTO_INCREMENT PRIMARY KEY, --id essiz yani primary key 
    adsoyad VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    sifre VARCHAR(255) NOT NULL,
    kayit_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Hedefler tablosu
CREATE TABLE hedefler (   

    id INT AUTO_INCREMENT PRIMARY KEY, -- id primary keydir
    kullanici_id INT NOT NULL,   --kullanıcı id mutlaka olmali
    baslik VARCHAR(255) NOT NULL,
    aciklama TEXT,
    tarih DATE,
    durum ENUM('Tamamlandı', 'Devam Ediyor', 'Başlamadı') DEFAULT 'Başlamadı',
    FOREIGN KEY (kullanici_id) REFERENCES kullanicilar(id) ON DELETE CASCADE
);
