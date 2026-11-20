# Teratai Cookies — terataicookies.com

Website publik **Jo&S Teratai Cookies & Cake**, Makassar. Berisi katalog kue kering, cake, dan hampers, dengan pemesanan lewat WhatsApp dan info outlet.

- **Laravel 12** (PHP 8.2+), Blade components, Vite. Tanpa Tailwind; CSS ada di `resources/css/app.css`.
- **Katalog langsung dari database admin** `u5653668_teratai` lewat user MySQL read-only, dengan file JSON sebagai cadangan.
- Tanpa payment gateway. Keranjang disimpan di browser, dan checkout membuka WhatsApp dengan pesan yang sudah terisi.
- Website **tidak butuh database sendiri**. Session dan cache memakai file.
- Desain minimalis mengikuti acuan di **[docs/DESAIN.md](docs/DESAIN.md)**.
- Lighthouse lokal (emulasi HP, `artisan serve`): Performance 99–100, Accessibility 100, Best Practices 100, SEO 100.

> Sebelum rilis, isi daftar di **[PLACEHOLDER.md](PLACEHOLDER.md)**.

## Menjalankan di komputer

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
npm run build          # atau: npm run dev (sambil mengedit)
php artisan serve      # http://localhost:8000
```

Test:

```bash
php artisan test       # katalog, halaman, query database admin
npm test               # format pesan WhatsApp
```

## Branch

| Branch | Fungsi |
|---|---|
| `development` | Tempat pengerjaan. Semua perubahan masuk ke sini dulu. |
| `production` | Versi yang tayang di terataicookies.com. Diperbarui dengan merge dari `development` setelah dicek. |

## Struktur

```
config/
  teratai.php          kontak, outlet, jam buka, musim, sumber katalog  ← isi di sini
  katalog.php          aturan tampil/sembunyi, ejaan rasa, urutan kemasan, favorit
  konten-produk.php    teks deskripsi website per produk
  faq.php              pertanyaan umum
  ikon.php             ikon garis tipis
app/
  Katalog/
    SumberDatabase.php   baca dari database admin (hanya kolom aman)
    SumberJson.php       baca dari database/data/katalog-db.json
    PembangunKatalog.php baris database → produk (rasa + varian kemasan)
    Katalog.php          akses + cache untuk controller
    Produk.php
  Support/Seo.php        Schema.org Bakery, Product, Breadcrumb, FAQ
  Support/helpers.php    rupiah(), link_wa(), link_petunjuk_arah(), dll.
  Http/Controllers/      HalamanController, ProdukController
resources/
  views/components/      header, pengumuman (bar musiman), footer, product-card, variant-picker,
                         cart-drawer, outlet-card, rak, foto, logo, icon, jejak (schema)
  views/pages/           beranda, produk (index, show), hampers, reseller, outlet, tentang, faq
  js/modul/              keranjang, pesan-wa, katalog (filter), detail, form-wa, header, rak, musim
  css/app.css
database/data/
  export-katalog.sql     query ekspor JSON (cadangan)
  user-readonly.sql      membuat user MySQL read-only untuk website
  katalog-db.json        katalog cadangan
```

## Data produk

Di database admin, satu baris `kue` adalah **satu rasa dalam satu kemasan**, dan tabel `kategori` berisi kemasan (Mika, Toples Bulat, dst.).
`PembangunKatalog` mengelompokkan baris berdasarkan rasa, sehingga website menampilkan satu produk per rasa dengan pilihan kemasan beserta harganya. Aturannya bisa diubah di `config/katalog.php` tanpa menyentuh view.

### Sumber katalog (`KATALOG_SUMBER` di `.env`)

| Nilai | Keterangan |
|---|---|
| `db` | **Disarankan untuk produksi.** Membaca langsung dari database admin, jadi harga dan produk baru langsung ikut. Hasilnya di-cache selama `KATALOG_CACHE_DETIK` (default 10 menit). |
| `json` | Membaca `database/data/katalog-db.json`. Dipakai untuk pengembangan, test, atau bila website tidak di server yang sama dengan database. |

Bila ingin perubahan di admin langsung tampil tanpa menunggu cache habis, jalankan `php artisan cache:clear`.

### User database read-only (wajib untuk `db`)

Jangan pakai user admin. Jalankan `database/data/user-readonly.sql` (ganti password dulu) lewat phpMyAdmin. User ini hanya bisa membaca kolom katalog yang aman:

- **bisa**: nama, kemasan, harga eceran, deskripsi, komposisi, `best`, `tampil`, nama file foto, varian, `kue_id` + `jumlah` penjualan (hanya untuk urutan "Terlaris")
- **tidak bisa**: `harga_reseller`, stok, pelanggan, users, token, detail nota

Sudah diuji dengan dump database: query website berjalan, sedangkan `SELECT harga_reseller` dan `SELECT * FROM pelanggan` ditolak database.

Lalu isi di `.env`:

```
KATALOG_SUMBER=db
ADMIN_DB_HOST=localhost
ADMIN_DB_DATABASE=u5653668_teratai
ADMIN_DB_USERNAME=teratai_web
ADMIN_DB_PASSWORD=...
```

### Memperbarui JSON cadangan

```bash
mariadb -N -r u5653668_teratai < database/data/export-katalog.sql > database/data/katalog-db.json
```

## Mode musiman

Isi `TERATAI_MUSIM=lebaran|natal|imlek|reguler` di `.env`, lalu jalankan `php artisan config:clear`. Bar pengumuman, warna aksen, dan koleksi unggulan ikut berganti tanpa mengubah layout.
Untuk pratinjau tanpa mengubah `.env`, buka `/?musim=lebaran`.

## Foto

Selama foto belum tersedia, setiap gambar tampil sebagai placeholder bertanda `[Foto] …`.

- **Foto produk dari admin**: isi `KATALOG_FOTO_BASE` dengan alamat folder foto di server admin. Nama file mengikuti tabel `gambar` (`{id}.{ext}`). Sebaiknya foto disajikan dalam format WebP dengan ukuran sekitar 800 px.
- **Foto suasana** (hero, hampers, dapur, tim): simpan di `public/img/`, lalu isi `'src' => '/img/...'` di view terkait (cari `'src' => null`).
- **Logo asli**: simpan sebagai `public/logo.svg`, `public/logo.webp`, atau `public/logo.png`. Header otomatis memakainya.

## Deploy ke hosting (cPanel)

Hosting saat ini menjalankan PHP 8.2, dan itu cukup untuk Laravel 12.

1. Di komputer, jalankan `composer install --no-dev --optimize-autoloader` dan `npm run build`.
2. Unggah seluruh folder proyek ke luar `public_html`, misalnya `~/teratai-web`. Folder `vendor/` dan `public/build/` ikut diunggah, karena hosting biasanya tidak punya Node.
3. Arahkan document root domain ke `~/teratai-web/public`. Bila tidak bisa, salin isi `public/` ke `public_html` lalu sesuaikan path di `public_html/index.php`.
4. Buat `.env` di server: `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://terataicookies.com`, isian Teratai, dan koneksi database admin. Lalu jalankan `php artisan key:generate`.
5. Pastikan `storage/` dan `bootstrap/cache/` bisa ditulis, lalu jalankan:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
