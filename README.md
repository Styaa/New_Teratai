# Teratai Cookies — terataicookies.com

Website publik Jo&S Teratai Cookies & Cake, Makassar. Berisi katalog kue kering, cake, dan hampers, dengan pemesanan lewat WhatsApp dan info outlet.

- **Astro 5**, situs statis. Hasil build di `dist/` bisa diunggah ke hosting apa pun (cPanel, Netlify, Cloudflare Pages, dll.).
- Tanpa payment gateway. Keranjang disimpan di browser, dan checkout membuka WhatsApp dengan pesan yang sudah terisi.
- Mobile-first. Lighthouse lokal (emulasi HP): Performance 99–100, Accessibility 100, Best Practices 100, SEO 100.

> Sebelum rilis, isi daftar di **[PLACEHOLDER.md](PLACEHOLDER.md)**.

## Menjalankan

```bash
npm install
npm run dev       # http://localhost:4321
npm run build     # hasil di dist/
npm run preview   # pratinjau hasil build
npm test          # unit test katalog & pesan WhatsApp
npm run check     # type-check
```

## Branch

| Branch | Fungsi |
|---|---|
| `development` | Tempat pengerjaan. Semua perubahan masuk ke sini dulu. |
| `production` | Versi yang tayang di terataicookies.com. Diperbarui dengan merge dari `development` setelah dicek. |

## Struktur

```
src/
  config/
    situs.ts          kontak, WhatsApp, outlet, jam buka  ← isi di sini
    musim.ts          mode musiman (reguler / lebaran / natal / imlek)
  data/
    katalog-db.json   ekspor katalog dari database admin (tanpa harga reseller)
    aturan-katalog.ts aturan tampil/sembunyi, ejaan rasa, urutan kemasan, favorit
    konten-produk.ts  teks deskripsi website per produk
  lib/
    katalog.ts        mengubah baris database → produk (rasa + varian kemasan)
    pesan-wa.ts       format rupiah & pesan WhatsApp
    seo.ts            Schema.org Bakery, Product, Breadcrumb, FAQ
  components/         Header, Footer, ProductCard, VariantPicker, CartDrawer,
                      OutletCard, SeasonalBanner, Rak (carousel), Foto, Logo, Icon
  pages/              beranda, produk, detail, hampers, reseller, outlet, tentang, faq,
                      sitemap.xml, robots.txt
  scripts/            keranjang.ts, form-wa.ts, muncul.ts
```

## Data produk

Di database admin, satu baris `kue` adalah **satu rasa dalam satu kemasan**, dan tabel `kategori` berisi kemasan (Mika, Toples Bulat, dst.).
`src/lib/katalog.ts` mengelompokkan baris berdasarkan rasa, sehingga website menampilkan satu produk per rasa dengan pilihan kemasan beserta harganya.

**Memperbarui katalog dari database** (di komputer yang punya akses MariaDB):

```bash
npm run ekspor-katalog
```

Perintah ini menjalankan `scripts/export-katalog.sql`. Yang diambil hanya nama, kemasan, harga eceran, deskripsi, komposisi, `best`, `tampil`, nama file foto, dan total terjual (yang ditampilkan hanya urutannya, bukan angkanya). Harga reseller, stok, pelanggan, dan transaksi tidak ikut diekspor.

**Mengambil dari API admin**: isi `ADMIN_API_URL` di `.env`. Endpoint harus mengembalikan `{ "kue": [...] }` dengan bentuk baris yang sama seperti `katalog-db.json` (lihat `BarisKue` di `src/lib/types.ts`). Desain tidak perlu diubah.

## Mode musiman

Isi `PUBLIC_MUSIM=lebaran|natal|imlek|reguler` di `.env` (default: `natal`), lalu build ulang. Banner, warna aksen, dan koleksi unggulan ikut berganti tanpa mengubah layout.
Untuk pratinjau tanpa build ulang, buka `/?musim=lebaran`.

## Foto

Selama foto belum tersedia, setiap gambar tampil sebagai placeholder bertanda `[Foto] …`.
- Foto produk dari admin: isi `PUBLIC_FOTO_BASE`. Nama file mengikuti tabel `gambar` (`{id}.{ext}`).
- Foto lokal: simpan di `src/assets/` dan pakai `<Picture>` dari `astro:assets`, yang otomatis membuat AVIF/WebP dan ukuran responsif.
