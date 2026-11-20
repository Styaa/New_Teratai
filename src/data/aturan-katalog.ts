/**
 * Aturan yang mengubah baris database admin menjadi katalog website.
 * Ubah file ini (bukan komponen) bila ingin menyembunyikan / menampilkan produk,
 * menyatukan ejaan rasa, atau mengganti urutan kemasan.
 */
import type { KategoriId, MusimId } from '@/lib/types';

/** Kemasan kue kering, sesuai urutan tampil di pemilih varian. Kunci = nama di tabel `kategori`. */
export const KEMASAN_KUE_KERING: Record<string, { label: string; urut: number }> = {
  'Mika': { label: 'Mika', urut: 1 },
  'Toples Tabung Kecil': { label: 'Toples Tabung Kecil', urut: 2 },
  'Toples Tabung Sedang': { label: 'Toples Tabung Sedang', urut: 3 },
  'Toples Tabung': { label: 'Toples Tabung', urut: 4 },
  'Toples Tabung Besar': { label: 'Toples Tabung Besar', urut: 5 },
  'Toples Tabung Spesial': { label: 'Toples Tabung Spesial', urut: 6 },
  'Toples Lonjong': { label: 'Toples Lonjong', urut: 7 },
  'Kotak Classic': { label: 'Kotak Classic', urut: 8 },
  'Kotak Roombutter': { label: 'Kotak Roombutter', urut: 9 },
  'Toples Bulat': { label: 'Toples Bulat', urut: 10 },
  'Toples Kotak': { label: 'Toples Kotak', urut: 11 },
  'Toples Segi 8': { label: 'Toples Segi 8', urut: 12 },
  'Toples 3 Rasa': { label: 'Toples 3 Rasa', urut: 13 },
  'Toples Kaca Kecil': { label: 'Toples Kaca Kecil', urut: 14 },
  'Toples Kaca Sedang': { label: 'Toples Kaca Sedang', urut: 15 },
  'Toples Kaca Tinggi': { label: 'Toples Kaca Tinggi', urut: 16 },
};

/** Jenis lain di tabel `kategori` dan ke mana masuknya di website. Yang tidak tercantum disembunyikan. */
export const KATEGORI_LAIN: Record<string, KategoriId> = {
  'Cake': 'cake',
  'Hampers': 'hampers',
  'Jalangkote & Lumpia': 'snack',
  'Selai': 'snack',
};

/**
 * Menyatukan ejaan rasa yang berbeda di database. Kunci huruf kecil.
 * [perlu konfirmasi] pastikan pasangan ini memang rasa yang sama.
 */
export const ALIAS_RASA: Record<string, string> = {
  'nastar bulat': 'Nastar',
  'keju coklat bulat': 'Keju Coklat',
  'speculash kenari': 'Spekulas Kenari',
  'speculas kenari': 'Spekulas Kenari',
  'spekulas kenari': 'Spekulas Kenari',
  'speculas': 'Spekulas Kenari',
  'blubery keju': 'Blueberry Keju',
  'chip mata': 'Coklat Chip Mata',
  'coklat chip mata': 'Coklat Chip Mata',
  'selai': 'Selai 3 Rasa',
  'campur 3 rasa': 'Toples 3 Rasa',
  'coklat koko crunch': 'Coklat Koko Krunch',
};

/**
 * Rasa kue kering yang selalu tampil (dari brief), walau flag `tampil` di admin = 0.
 * Rasa lain tampil hanya bila minimal satu kemasannya `tampil = 1`.
 */
export const RASA_WAJIB_TAMPIL = [
  'Nastar', 'Nastar Daun', 'Kastengel', 'Keju', 'Keju Coklat', 'Coklat Chip', 'Coklat Mente',
  'Coklat Cornflake', 'Mente', 'Mente Keju', 'Belinjo', 'Belinjo Keju', 'Kacang', 'Kacang Coklat',
  'Bangket Kacang', 'Bangket Mente', 'Salju', 'Sagu', 'Blueberry Keju', 'Stick Coklat', 'Kopi',
  'Selai 3 Rasa', 'Tosca', 'Toples 3 Rasa',
];

/** Badge "Favorit" (dari brief). Urutan "Terlaris" tetap memakai data penjualan. */
export const FAVORIT = [
  'Nastar', 'Keju Coklat', 'Coklat Chip', 'Mente', 'Coklat Cornflake', 'Belinjo', 'Keju',
  'Kastengel', 'Nastar Daun',
];

/** Nama yang mengandung kata ini tidak pernah tampil (barang internal / bonus). */
export const SEMBUNYIKAN_POLA = [/tester/i, /^bonus\b/i, /minyak bekas/i];

/** Cake & kue basah yang digabung menjadi satu produk dengan pilihan rasa. */
export const GABUNG_CAKE: { pola: RegExp; nama: string; labelVarian: 'Rasa' | 'Ukuran'; varian: (nama: string) => string }[] = [
  {
    pola: /^chiffon (keju|coklat|pandan) 20 ?cm$/i,
    nama: 'Chiffon Cake 20 cm',
    labelVarian: 'Rasa',
    varian: (n) => n.replace(/^chiffon (\w+).*$/i, (_, r: string) => r[0].toUpperCase() + r.slice(1)),
  },
];

/** Nama tampilan untuk produk tertentu (kunci = nama di database, huruf kecil). */
export const NAMA_TAMPIL: Record<string, string> = {
  'brownis kukus': 'Brownis Kukus',
  'keju gonrong 30 cm': 'Keju Gonrong 30 cm',
  'marbel cake': 'Marmer Cake',
  'bolu rampah': 'Bolu Rampah',
  'otak otak': 'Otak-otak',
  'risol mayo': 'Risol Mayo',
  'risol mentai': 'Risol Mentai',
  'pudding coklat': 'Puding Coklat',
};

/** Cake / snack hanya tampil bila `tampil = 1` di admin, kecuali Jalangkote Lasinrang (semua item berharga). */
export const SNACK_SELALU_TAMPIL = ['Jalangkote & Lumpia'];

/** Hampers: tampil bila harga ≥ batas ini (yang lebih murah adalah kemasan/isi, bukan paket). */
export const HAMPERS_HARGA_MINIMUM = 95_000;

/** Penanda musim dari nama hampers. */
export const MUSIM_DARI_NAMA: { pola: RegExp; musim: MusimId }[] = [
  { pola: /natal/i, musim: 'natal' },
  { pola: /imlek/i, musim: 'imlek' },
  { pola: /idul ?fit|ramadhan|lebaran/i, musim: 'lebaran' },
];

/** Rasa yang identik dengan musim tertentu (untuk koleksi musiman). */
export const RASA_MUSIMAN: Record<Exclude<MusimId, 'reguler'>, string[]> = {
  lebaran: ['Nastar', 'Kastengel', 'Bangket Kacang', 'Bangket Mente', 'Salju', 'Toples 3 Rasa'],
  natal: ['Nastar', 'Kastengel', 'Tosca', 'Spekulas Kenari', 'Salju', 'Coklat Mente'],
  imlek: ['Nastar', 'Kastengel', 'Keju Coklat', 'Mente Keju', 'Kacang'],
};
