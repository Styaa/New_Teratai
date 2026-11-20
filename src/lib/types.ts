/** Baris mentah dari database admin (lihat scripts/export-katalog.sql). Satu baris = satu rasa dalam satu kemasan. */
export interface BarisKue {
  id: number;
  nama: string;
  kemasan: string; // tabel `kategori` di admin berisi kemasan / jenis
  harga: number;
  deskripsi: string | null;
  komposisi: string | null;
  best: 0 | 1 | number;
  tampil: 0 | 1 | number;
  gambar: string[] | null; // nama file "{id}.{ext}" dari tabel `gambar`
  varian: { nama: string; harga: number | null }[] | null;
  terjual: number;
}

export type KategoriId = 'kue-kering' | 'cake' | 'hampers' | 'snack';
export type MusimId = 'reguler' | 'lebaran' | 'natal' | 'imlek';
export type Alergen = 'gluten' | 'telur' | 'susu' | 'kacang';

export interface Varian {
  /** id unik di dalam produk, dipakai keranjang */
  id: string;
  nama: string;
  harga: number | null; // null = harga dikonfirmasi admin
  kueId: number;
}

export interface Foto {
  src: string | null; // null = placeholder
  alt: string;
  label: string; // keterangan placeholder, mis. "Close-up tekstur"
}

export interface Produk {
  slug: string;
  nama: string;
  kategori: KategoriId;
  labelVarian: 'Kemasan' | 'Rasa' | 'Ukuran' | 'Pilihan';
  varian: Varian[];
  hargaMulai: number | null;
  hargaTertinggi: number | null;
  ringkas: string; // satu kalimat untuk kartu & meta description
  deskripsi: string;
  komposisi: string | null;
  alergen: Alergen[];
  best: boolean;
  tampil: boolean;
  /** urutan terlaris (1 = paling laris), dari data penjualan */
  peringkat: number;
  foto: Foto[];
  musim: MusimId[];
  merek?: string; // mis. "Jalangkote Lasinrang"
}
