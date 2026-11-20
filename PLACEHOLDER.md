# Yang perlu diisi sebelum rilis

Di website, semua yang belum final ditandai kotak kuning bergaris putus-putus, misalnya `[perlu konfirmasi]`, `[contoh]`, atau `[Foto] …`.
Website tetap bisa dipakai selama placeholder ini belum diisi, tetapi **jangan rilis ke publik sebelum bagian A dan B selesai.**

## A. Kontak & toko (wajib) — `config/teratai.php` dan `.env`

| Isian | Lokasi | Catatan |
|---|---|---|
| Nomor WhatsApp utama | `.env` → `TERATAI_WHATSAPP` | Format `62812xxxxxxx`. Selama kosong, tombol WA membuka WhatsApp dan pelanggan memilih kontak sendiri. |
| Nomor WhatsApp per outlet | `outlet.*.whatsapp` | Pesanan "ambil di outlet" dikirim ke nomor outlet tersebut. Kosong = memakai nomor utama. |
| Jam buka Pelita & Hertasning | `outlet.*.jam` | Contoh ada di komentar `config/teratai.php`. |
| Koordinat kedua outlet | `outlet.*.geo` | Dari Google Maps: klik kanan pin → salin angka. Dipakai untuk schema SEO lokal dan tombol "Petunjuk Arah". |
| Instagram | `.env` → `TERATAI_INSTAGRAM` | Tanpa `@`. |
| Link GrabFood / GoFood | `grabfood`, `gofood` | Kosongkan bila tidak ada. |
| Link Mie Ayam Teratai | `keluarga_usaha.0.tautan` | Instagram atau aplikasi pesan antar. |
| Tahun berdiri | `tahun_berdiri` | Hanya tampil bila diisi. |

## B. Klaim yang perlu dikonfirmasi (wajib)

| Klaim | Halaman | File |
|---|---|---|
| Status halal | FAQ | `config/faq.php` |
| Daya tahan kue per jenis | FAQ | `config/faq.php` |
| Kurir & area antar, kebijakan kirim luar kota | FAQ | `config/faq.php` |
| Bank untuk transfer, kebijakan DP pre-order | FAQ, Hampers | `config/faq.php`, `resources/views/pages/hampers.blade.php` |
| Kartu ucapan gratis atau berbayar | Hampers | `resources/views/pages/hampers.blade.php` |
| Paket hampers musiman yang masih dijual | Hampers | lihat bagian D |
| Syarat reseller (minimal order, pembayaran) | Reseller | `resources/views/pages/reseller.blade.php` |
| Proses pembuatan (dibentuk tangan, dll.) | Tentang | `resources/views/pages/tentang.blade.php` |
| Dapur juga mengolah kacang/susu/telur/terigu | Detail produk | `resources/views/pages/produk/show.blade.php` |
| Isi "Toples 3 Rasa" | Detail produk | `config/konten-produk.php` |
| Daya simpan per jenis kue | Detail produk (akordeon) | `resources/views/pages/produk/show.blade.php` |
| Pengiriman memakai kurir Gojek / Grab | Keranjang | `resources/views/components/cart-drawer.blade.php` |
| Berat per kemasan (mis. Mika 100 g), bila ingin ditampilkan | Detail produk | belum ada di database admin |

Klaim "tanpa pengawet", "sejak 19xx", dan "mentega Wijsman murni" sengaja **tidak** dipakai sampai dikonfirmasi. Begitu juga nomor WA, Instagram, dan jam buka yang tertera di desain referensi (lihat `docs/DESAIN.md` bagian 4).

## C. Foto & konten

- **Foto produk**: tabel `gambar` di admin sudah berisi 338 nama file. Isi `KATALOG_FOTO_BASE` di `.env` dengan alamat folder foto di server admin (mis. `https://admin.terataicookies.com/storage/kue`). Sebaiknya foto disajikan dalam format WebP.
- **Foto suasana** (hero beranda, hampers, dapur, proses, tim): simpan di `public/img/`, lalu ganti `'src' => null` di view terkait.
- **Arah foto**: cahaya alami; latar kayu, linen, atau cream; close-up tekstur (remahan nastar, keju kastengel); toples tersusun. Hindari foto stok.
- **Logo asli**: simpan sebagai `public/logo.svg`, `public/logo.webp`, atau `public/logo.png`. Header otomatis memakainya. Saat ini header memakai gambar ulang tanda teratai (`resources/views/components/tanda-teratai.blade.php`).
- **Testimoni**: 3 kartu `[contoh]` di `resources/views/pages/beranda.blade.php` (`$testimoni`). Isi hanya dengan kutipan asli yang sudah diizinkan pelanggan.
- **Cerita pendiri & foto tim**: `resources/views/pages/tentang.blade.php`.

## D. Data katalog yang perlu dicek di admin

Data diambil dari database `u5653668_teratai`. Aturan penyaringannya ada di `config/katalog.php`.

1. **Flag `tampil`**: banyak kemasan Toples Tabung, Kaca, dan Kotak masih `tampil = 0` di admin. Website tetap menampilkan semua kemasan dari rasa yang tercantum di brief (`rasa_wajib_tampil`). Pilih salah satu: rapikan flag `tampil` di admin, atau ubah daftar ini.
2. **Ejaan ganda** yang sudah disatukan (cek apakah memang rasa yang sama): Speculash/Spekulas/Speculas Kenari, Nastar Bulat → Nastar, Keju Coklat Bulat → Keju Coklat, Chip Mata → Coklat Chip Mata, Selai (Kotak Classic) → Selai 3 Rasa, Blubery → Blueberry. Lihat `alias_rasa`.
3. **"Coklat Keju" dan "Keju Coklat"** di Toples Tabung adalah dua baris berbeda. "Coklat Keju" disembunyikan karena tidak ada di brief.
4. **Toples Tabung (Rp 85.000) dan Toples Tabung Besar (Rp 85.000)**: harganya sama. Apakah ini kemasan yang sama?
5. **Hampers**: semua paket ≥ Rp 95.000 yang belum dihapus akan tampil, termasuk paket Natal, Imlek, dan Idul Fitri. Hapus (soft delete) paket yang sudah tidak dijual.
6. **Kategori "Snack"** di website berisi Jalangkote Lasinrang (jalangkote, lumpia, risol, dll.) dan Selai Nastar. Snack bermerek titipan (Momogi, Pilus, dll.) disembunyikan.
7. **Badge "Favorit"** memakai daftar dari brief. Urutan "Terlaris" memakai data penjualan, dan Kacang adalah rasa yang paling banyak terjual.
8. Beberapa **deskripsi** di admin memakai bahasa santai ("endoss", "galau"). Website memakai teks baru di `config/konten-produk.php`. Deskripsi admin hanya dipakai bila teks baru belum ada.

## E. Database

- Untuk `KATALOG_SUMBER=db`, buat user read-only dengan `database/data/user-readonly.sql`. Jangan pakai user admin.

## F. Catatan warna

Teks putih di atas terracotta `#C26D4D` kontrasnya 3,8:1, belum lolos WCAG AA untuk teks normal. Karena itu tombol utama memakai `#A85A3D` (5,0:1) dengan hover `#8E4A31`. `#C26D4D` tetap dipakai untuk aksen, ikon, dan elemen dekoratif.
