/**
 * Data toko. Semua yang bertanda TODO / [perlu konfirmasi] wajib diisi pemilik sebelum rilis.
 * Daftar lengkap: PLACEHOLDER.md
 */

export interface JamBuka {
  hari: string; // "Senin–Sabtu"
  buka: string; // "08:00"
  tutup: string; // "21:00"
  /** Schema.org dayOfWeek, mis. ["Monday","Tuesday"] */
  schemaHari: string[];
}

export interface Outlet {
  id: 'pelita' | 'hertasning';
  nama: string;
  jalan: string;
  kelurahan: string;
  kecamatan: string;
  kota: string;
  provinsi: string;
  kodePos: string;
  /** Format 62xxxxxxxxxx tanpa + atau spasi. TODO: isi nomor WhatsApp outlet. */
  whatsapp: string;
  /** TODO: isi jam buka. Kosong = tampil "Jam buka segera diumumkan". */
  jam: JamBuka[];
  /** TODO [perlu konfirmasi]: koordinat dari Google Maps (klik kanan pada pin → salin angka). */
  geo: { lat: number; lng: number } | null;
}

export const SITUS = {
  nama: 'Teratai Cookies',
  namaLengkap: 'Jo&S Teratai Cookies & Cake',
  url: 'https://terataicookies.com',
  kota: 'Makassar',
  /** Nomor WhatsApp pemesanan utama, format 62xxxxxxxxxx. TODO: isi.
   *  Selama kosong, tombol WhatsApp membuka WhatsApp dengan pesan terisi dan pelanggan memilih kontak sendiri. */
  whatsapp: '',
  /** TODO: username Instagram tanpa @ */
  instagram: '',
  /** TODO: link GrabFood / GoFood bila ada */
  grabfood: '',
  gofood: '',
  /** TODO [perlu konfirmasi]: tahun berdiri. Kosong = tidak ditampilkan. */
  tahunBerdiri: '',
  deskripsi:
    'Kue kering rumahan dari dapur Teratai, Makassar, dibuat dengan bahan pilihan untuk setiap momen berharga.',
  /** Minimal hari pemesanan untuk pre-order hampers / partai besar. */
  preorderHari: 3,
};

export const OUTLET: Outlet[] = [
  {
    id: 'pelita',
    nama: 'Teratai Pelita',
    jalan: 'Jl. Pelita Raya No. 28',
    kelurahan: 'Balla Parang',
    kecamatan: 'Rappocini',
    kota: 'Makassar',
    provinsi: 'Sulawesi Selatan',
    kodePos: '90231',
    whatsapp: '',
    jam: [],
    geo: null,
  },
  {
    id: 'hertasning',
    nama: 'Teratai Hertasning',
    jalan: 'Jl. Aroeppala No. 6',
    kelurahan: 'Karunrung',
    kecamatan: 'Rappocini',
    kota: 'Makassar',
    provinsi: 'Sulawesi Selatan',
    kodePos: '90221',
    whatsapp: '',
    jam: [],
    geo: null,
  },
];

export const alamatLengkap = (o: Outlet) =>
  `${o.jalan}, ${o.kelurahan}, Kec. ${o.kecamatan}, ${o.kota}, ${o.provinsi} ${o.kodePos}`;

const qMaps = (o: Outlet) => encodeURIComponent(`Teratai Cookies ${o.jalan}, ${o.kelurahan}, ${o.kota}`);

export const linkPetunjukArah = (o: Outlet) =>
  o.geo
    ? `https://www.google.com/maps/dir/?api=1&destination=${o.geo.lat},${o.geo.lng}`
    : `https://www.google.com/maps/dir/?api=1&destination=${qMaps(o)}`;

export const linkEmbedPeta = (o: Outlet) =>
  `https://www.google.com/maps?q=${o.geo ? `${o.geo.lat},${o.geo.lng}` : qMaps(o)}&z=16&output=embed`;

export const KELUARGA_USAHA = [
  {
    nama: 'Mie Ayam Teratai',
    deskripsi: 'Mie ayam dengan pangsit dan bakso, dari dapur yang sama.',
    tautan: '', // TODO: link Instagram / GrabFood bila ada
  },
  {
    nama: 'Jalangkote Lasinrang',
    deskripsi: 'Jalangkote dan lumpia khas Makassar, tersedia juga versi frozen.',
    tautan: '/produk/?kategori=snack',
  },
];
