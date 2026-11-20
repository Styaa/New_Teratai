# Acuan Desain — Teratai Cookies

Analisis tiga referensi (beranda, katalog, detail produk + keranjang) yang dipakai sebagai arah visual website.
Prinsip utamanya: **foto produk jadi bintang, antarmuka mundur ke belakang.** Minimalis dan bersih, tetapi informasinya tetap lengkap.

## 1. Prinsip

| Prinsip | Wujud di referensi | Penerapan |
|---|---|---|
| Ruang kosong lega | Jarak antarbagian besar, teks kecil, kolom tidak penuh | Bagian berjarak 96–120 px di desktop, 64 px di HP |
| Hierarki lewat ukuran & warna, bukan ketebalan | Judul berat 500, bukan 700–800. Teks sekunder abu hangat | Judul Hanken Grotesk 500; teks sekunder `#6B5F56` |
| Garis tipis sebagai pemisah | Garis 1 px di bawah judul bagian, di footer, dan antarbaris kemasan | `#EFE8E0` dipakai konsisten; kartu tanpa border dan tanpa bayangan |
| Aksen hemat | Terracotta hanya untuk tombol utama, menu aktif, kata aksen, dan label "Favorit" | Badge berwarna di atas foto diganti teks kecil di bawah nama |
| Satu aksi utama per layar | Hero: tombol pil + tautan teks "Lihat produk →" | Tombol sekunder memakai tautan teks atau tombol garis |
| Label kecil berhuruf kapital | "PILIHAN KEMASAN", "JUMLAH", "KERANJANG PESANAN" | 11–12 px, kapital, jarak huruf 0.12em, abu |

## 2. Token

| Token | Nilai | Catatan |
|---|---|---|
| Latar | `#FBF8F4` (utama), `#F7F2EC` (selingan) | Footer ikut terang, tidak lagi gelap |
| Teks | `#2A2420` | |
| Teks sekunder | `#6B5F56` | Kontras 5,8:1 di atas latar (lolos AA) |
| Garis | `#EFE8E0` | |
| Aksen | `#C26D4D` (dekoratif), `#A85A3D` (tombol, 5,0:1), `#94502F` (teks aksen kecil) | Lihat catatan kontras di PLACEHOLDER.md |
| Radius | foto 6 px, tombol pil 999 px, input 8 px | Lebih tajam dari sebelumnya (14–20 px) |
| Bayangan | hanya laci keranjang | Kartu dan foto datar |
| Judul | Hanken Grotesk 500, -0.02em | H1 32–48 px, H2 22–28 px |
| Aksen kata | Instrument Serif italic | Hanya 1 kata di hero ("*ingat*"), warna terracotta |
| Teks | Inter 400/500, 15 px; teks kecil 13 px | Angka harga tabular |
| Tombol | tinggi 44–48 px, teks 14 px berat 500 | Tetap ≥ 44 px untuk jempol |

## 3. Komponen

**Header.** Tingginya 64 px. Logo kecil (tanda teratai + "Teratai Cookies") di kiri, menu 14 px abu di tengah dengan item aktif berwarna terracotta, ikon keranjang berlencana angka dan tautan "WhatsApp" di kanan. Di atasnya ada **bar pengumuman musiman** satu baris (mis. "Pre-order Natal & hampers musiman dibuka…").

**Kartu produk.** Foto rasio 4:5 radius 6 px tanpa badge. Di bawahnya: nama (14–15 px, 500), "Favorit" (teks kecil terracotta), lalu "Mulai Rp 30.000" (abu). Tidak ada deskripsi, supaya grid tenang. Hover: foto sedikit membesar.

**Judul bagian.** Judul di kiri dan "Lihat semua →" kecil di kanan, dengan garis tipis di bawahnya.

**Katalog.** Judul dan subjudul di atas. Toolbar satu baris: tab kategori berupa teks (yang aktif bergaris bawah), lalu pencarian bergaya garis bawah dan pilihan urutan minimal di kanan. Grid 3 kolom di desktop, 2 kolom di HP.

**Detail produk.**
- Tautan kembali "← KATALOG".
- Kiri: foto besar dan deretan thumbnail.
- Kanan, dari atas: label kategori & Favorit, judul, ringkasan, harga besar + kemasan terpilih, "PILIHAN KEMASAN" sebagai **daftar baris** (nama kiri, harga kanan; yang terpilih bergaris kiri terracotta), baris "JUMLAH" dengan − 1 +.
- Dua tombol: **Pesan via WhatsApp** (utama, langsung untuk item ini) dan **Tambah ke Pesanan** (garis).
- Akordeon: Profil Rasa & Tekstur, Bahan Baku, Catatan Alergen & Daya Simpan.
- "Kue Lainnya": 3 kartu.

**Keranjang (laci kanan).** Latar belakang halaman hanya diredupkan tipis. Judul kecil kapital. Setiap item: nama, kemasan × jumlah, dan harga di kanan. Pilihan pengambilan berupa daftar radio (Ambil di Pelita / Ambil di Hertasning / Kirim kurir Gojek atau Grab). Di bawah: tanggal, nama, catatan, lalu "Total Perkiraan" dan tombol pil "Kirim Pesanan ke WhatsApp".

**Hampers.** Foto di kiri, teks di kanan, dan tautan "Lihat pilihan hampers →".

**Outlet.** Dua kolom teks tanpa kartu: nama (500), alamat, jam buka, "Petunjuk arah →".

**Footer.** Terang, dengan garis atas. Kolom: brand + deskripsi, lokasi outlet, menu, hubungi. Baris bawahnya berisi hak cipta di kiri dan "Makassar, Sulawesi Selatan" di kanan.

## 4. Yang sengaja TIDAK diambil dari referensi

Referensi berisi data contoh yang belum tentu benar. Data ini tidak dipakai sampai dikonfirmasi pemilik:

- Klaim "sejak 1998", "tanpa bahan pengawet", "mentega Wijsman murni", "resep turun-temurun"
- Nomor WhatsApp `+62 811-444-199`, Instagram `@terataicookies`, jam buka 08.00–21.00 / 08.00–22.00 WITA
- Harga dan berat kemasan (mis. Mika 100 g Rp 25.000). Harga website tetap diambil dari database admin. Berat kemasan belum ada di database. **[perlu konfirmasi: berat per kemasan]**
- Nama produk yang berbeda dari database (mis. "Nastar Wisman Teratai", "Kastengel Edam Keju Tua")
- Teks yang tertempel di dalam foto contoh (judul katalog, tangkapan layar)

## 5. Foto

Arah fotonya sama dengan referensi: cahaya alami, piring keramik dan talenan kayu, latar linen atau cream, close-up tekstur, dan toples bermerek Teratai. Hindari foto yang berisi teks atau tangkapan layar (lihat kartu "Nastar Daun Premium" dan "Paket Hampers Raya" di referensi). Ukuran yang disarankan 1200×1500 px (4:5), format WebP.
