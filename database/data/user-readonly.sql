-- User MySQL khusus website: hanya bisa MEMBACA kolom katalog yang aman.
-- Tidak bisa membaca harga_reseller, stok, pelanggan, users, token, atau detail transaksi.
-- Ganti 'GANTI_PASSWORD' lalu jalankan sebagai admin database (phpMyAdmin → tab SQL).
-- Di hosting cPanel, nama user & database biasanya berawalan akun (mis. u5653668_web).
CREATE USER IF NOT EXISTS 'teratai_web'@'localhost' IDENTIFIED BY 'GANTI_PASSWORD';

GRANT SELECT (id, nama, harga, deskripsi, kategori_id, komposisi, best, tampil, deleted_at) ON u5653668_teratai.kue TO 'teratai_web'@'localhost';
GRANT SELECT (id, nama) ON u5653668_teratai.kategori TO 'teratai_web'@'localhost';
GRANT SELECT (id, ext, kue_id) ON u5653668_teratai.gambar TO 'teratai_web'@'localhost';
GRANT SELECT (id, kue_id, nama_varian, harga) ON u5653668_teratai.kue_varian TO 'teratai_web'@'localhost';
-- Hanya kue_id & jumlah: untuk urutan "Terlaris" (angka penjualan tidak ditampilkan di website)
GRANT SELECT (kue_id, jumlah) ON u5653668_teratai.nota_has_kue TO 'teratai_web'@'localhost';
GRANT SELECT (kue_id, jumlah) ON u5653668_teratai.t_notas_has_kue TO 'teratai_web'@'localhost';

FLUSH PRIVILEGES;
