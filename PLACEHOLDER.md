# Yang perlu diisi sebelum rilis

Di website, semua yang belum final ditandai kotak kuning bergaris putus-putus, misalnya `[perlu konfirmasi]`, `[contoh]`, atau `[Foto] …`.
Website tetap bisa dipakai selama placeholder ini belum diisi, tetapi **jangan rilis ke publik sebelum bagian A dan B selesai.**

## A. Kontak & toko (wajib) — `src/config/situs.ts`

| Isian | Lokasi | Catatan |
|---|---|---|
| Nomor WhatsApp utama | `SITUS.whatsapp` | Format `62812xxxxxxx`. Selama kosong, tombol WA membuka WhatsApp dan pelanggan memilih kontak sendiri. |
| Nomor WhatsApp per outlet | `OUTLET[].whatsapp` | Pesanan "ambil di outlet" dikirim ke nomor outlet tersebut. Kosong = memakai nomor utama. |
| Jam buka Pelita & Hertasning | `OUTLET[].jam` | Contoh: `{ hari: 'Senin–Sabtu', buka: '08:00', tutup: '21:00', schemaHari: ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] }` |
| Koordinat kedua outlet | `OUTLET[].geo` | Dari Google Maps: klik kanan pin → salin angka. Dipakai untuk schema SEO lokal dan tombol "Petunjuk Arah". |
| Instagram | `SITUS.instagram` | Tanpa `@`. |
| Link GrabFood / GoFood | `SITUS.grabfood`, `SITUS.gofood` | Kosongkan bila tidak ada. |
| Link Mie Ayam Teratai | `KELUARGA_USAHA[0].tautan` | Instagram atau aplikasi pesan antar. |
| Tahun berdiri | `SITUS.tahunBerdiri` | Hanya tampil bila diisi. |

## B. Klaim yang perlu dikonfirmasi (wajib)

| Klaim | Halaman | File |
|---|---|---|
| Status halal | FAQ | `src/pages/faq.astro` |
| Daya tahan kue per jenis | FAQ | `src/pages/faq.astro` |
| Kurir & area antar, kebijakan kirim luar kota | FAQ | `src/pages/faq.astro` |
| Bank untuk transfer, kebijakan DP pre-order | FAQ, Hampers | `faq.astro`, `hampers.astro` |
| Kartu ucapan gratis atau berbayar | Hampers | `src/pages/hampers.astro` |
| Paket hampers musiman yang masih dijual | Hampers | lihat bagian D |
| Syarat reseller (minimal order, pembayaran) | Reseller | `src/pages/reseller.astro` |
| Proses pembuatan (dibentuk tangan, dll.) | Tentang | `src/pages/tentang.astro` |
| Dapur juga mengolah kacang/susu/telur/terigu | Detail produk | `src/pages/produk/[slug].astro` |
| Isi "Toples 3 Rasa" | Detail produk | `src/data/konten-produk.ts` |

Klaim "tanpa pengawet" dan "sejak 19xx" sengaja **tidak** dipakai sampai dikonfirmasi.

## C. Foto & konten

- **Foto produk**: tabel `gambar` di admin sudah berisi 338 nama file. Isi `PUBLIC_FOTO_BASE` di `.env` dengan alamat folder foto di server admin (mis. `https://admin.terataicookies.com/storage/kue`), lalu build ulang. Sebaiknya foto disajikan dalam format WebP.
- **Foto suasana** (hero beranda, hampers, dapur, proses, tim): ganti `src` di halaman terkait. Cari teks `src: null`.
- **Arah foto**: cahaya alami; latar kayu, linen, atau cream; close-up tekstur (remahan nastar, keju kastengel); toples tersusun. Hindari foto stok.
- **Logo asli**: simpan sebagai `public/logo.svg`, `public/logo.webp`, atau `public/logo.png`. Header otomatis memakainya. Saat ini header memakai gambar ulang tanda teratai (`src/components/TandaTeratai.astro`).
- **Testimoni**: 3 kartu `[contoh]` di `src/pages/index.astro` (`TESTIMONI`). Isi hanya dengan kutipan asli yang sudah diizinkan pelanggan.
- **Cerita pendiri & foto tim**: `src/pages/tentang.astro`.

## D. Data katalog yang perlu dicek di admin

Data diambil dari database `u5653668_teratai`. Aturan penyaringannya ada di `src/data/aturan-katalog.ts`.

1. **Flag `tampil`**: banyak kemasan Toples Tabung, Kaca, dan Kotak masih `tampil = 0` di admin. Website tetap menampilkan semua kemasan dari rasa yang tercantum di brief (`RASA_WAJIB_TAMPIL`). Pilih salah satu: rapikan flag `tampil` di admin, atau ubah daftar ini.
2. **Ejaan ganda** yang sudah disatukan (cek apakah memang rasa yang sama): Speculash/Spekulas/Speculas Kenari, Nastar Bulat → Nastar, Keju Coklat Bulat → Keju Coklat, Chip Mata → Coklat Chip Mata, Selai (Kotak Classic) → Selai 3 Rasa, Blubery → Blueberry. Lihat `ALIAS_RASA`.
3. **"Coklat Keju" dan "Keju Coklat"** di Toples Tabung adalah dua baris berbeda. "Coklat Keju" disembunyikan karena tidak ada di brief.
4. **Toples Tabung (Rp 85.000) dan Toples Tabung Besar (Rp 85.000)**: harganya sama. Apakah ini kemasan yang sama?
5. **Hampers**: semua paket ≥ Rp 95.000 yang belum dihapus akan tampil, termasuk paket Natal, Imlek, dan Idul Fitri. Hapus (soft delete) paket yang sudah tidak dijual.
6. **Kategori "Snack"** di website berisi Jalangkote Lasinrang (jalangkote, lumpia, risol, dll.) dan Selai Nastar. Snack bermerek titipan (Momogi, Pilus, dll.) disembunyikan.
7. **Badge "Favorit"** memakai daftar dari brief. Urutan "Terlaris" memakai data penjualan, dan Kacang adalah rasa yang paling banyak terjual.
8. Beberapa **deskripsi** di admin memakai bahasa santai ("endoss", "galau"). Website memakai teks baru di `src/data/konten-produk.ts`. Deskripsi admin hanya dipakai bila teks baru belum ada.

## E. Catatan warna

Teks putih di atas terracotta `#C26D4D` kontrasnya 3,8:1, belum lolos WCAG AA untuk teks normal. Karena itu tombol utama memakai `#A85A3D` (5,0:1) dengan hover `#8E4A31`. `#C26D4D` tetap dipakai untuk aksen, ikon, dan elemen dekoratif.
