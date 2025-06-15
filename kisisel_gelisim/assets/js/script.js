document.addEventListener("DOMContentLoaded", function() {
    // Form validasyonu
    const hedefForm = document.getElementById("hedefForm");
    if (hedefForm) {
        hedefForm.addEventListener("submit", function(e) {
            const baslik = document.getElementById("baslik").value.trim();
            const tarih = document.getElementById("tarih").value.trim();

            if (baslik === "") {
                alert("Hedef başlığı boş bırakılamaz.");
                e.preventDefault();
                return;
            }

            if (tarih !== "") {
                const tarihObj = new Date(tarih);
                const bugun = new Date();
                bugun.setHours(0,0,0,0);
                if (tarihObj < bugun) {
                    alert("Hedef tarihi bugünden küçük olamaz.");
                    e.preventDefault();
                    return;
                }
            }
        });
    }

    // Hedef silme onayı
    const silBtnList = document.querySelectorAll(".hedef-sil-btn");
    silBtnList.forEach(btn => {
        btn.addEventListener("click", function(e) {
            if (!confirm("Bu hedefi silmek istediğinize emin misiniz?")) {
                e.preventDefault();
            }
        });
    });

    // Durum filtreleme
    const durumFilter = document.getElementById("durumFilter");
    if (durumFilter) {
        durumFilter.addEventListener("change", function() {
            const secilenDurum = this.value;
            const hedefler = document.querySelectorAll(".hedef-item");
            hedefler.forEach(item => {
                if (secilenDurum === "hepsi" || item.dataset.durum === secilenDurum) {
                    item.style.display = "block";
                } else {
                    item.style.display = "none";
                }
            });
        });
    }
});
