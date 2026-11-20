/**
 * Membangun katalog website dari baris database admin.
 * Sumber data:
 *  - ADMIN_API_URL (opsional, saat build): GET {ADMIN_API_URL} → { kue: BarisKue[] }
 *  - fallback: src/data/katalog-db.json (hasil scripts/export-katalog.sql)
 * Desain tidak perlu diubah ketika sumber data berganti, selama bentuk BarisKue sama.
 */
import dataLokal from '@/data/katalog-db.json';
import {
  ALIAS_RASA, FAVORIT, GABUNG_CAKE, HAMPERS_HARGA_MINIMUM, KATEGORI_LAIN, KEMASAN_KUE_KERING,
  MUSIM_DARI_NAMA, NAMA_TAMPIL, RASA_MUSIMAN, RASA_WAJIB_TAMPIL, SEMBUNYIKAN_POLA, SNACK_SELALU_TAMPIL,
} from '@/data/aturan-katalog';
import { KONTEN_PRODUK } from '@/data/konten-produk';
import type { Alergen, BarisKue, Foto, KategoriId, MusimId, Produk, Varian } from './types';

export const slugify = (s: string) =>
  s.toLowerCase().normalize('NFKD').replace(/[^\w\s-]/g, '').trim().replace(/[\s_]+/g, '-').replace(/-+/g, '-');

const titleCase = (s: string) =>
  s.trim().replace(/\s+/g, ' ').toLowerCase().replace(/(^|[\s(-])(\p{L})/gu, (_, a: string, b: string) => a + b.toUpperCase());

export const bersihkanHtml = (html: string | null | undefined) =>
  (html ?? '')
    .replace(/<\/(p|li|div)>/gi, '\n')
    .replace(/<br\s*\/?>/gi, '\n')
    .replace(/<[^>]+>/g, '')
    .replace(/&nbsp;/g, ' ')
    .replace(/&amp;/g, '&')
    .replace(/&quot;/g, '"')
    .replace(/&#39;/g, "'")
    .replace(/[ \t]+/g, ' ')
    .replace(/\n\s*\n+/g, '\n')
    .trim();

const komposisiValid = (k: string | null) => {
  const t = (k ?? '').trim();
  if (!t || t === '-' || t === '0' || /^(yes|snack|cake|cookies|puding|i)$/i.test(t)) return null;
  return t.replace(/\s*,\s*/g, ', ').replace(/,\s*$/, '');
};

export function deteksiAlergen(teks: string): Alergen[] {
  const t = teks.toLowerCase();
  const hasil: Alergen[] = [];
  if (/tepung|terigu|cornflake|koko|biskuit|roti/.test(t)) hasil.push('gluten');
  if (/telur/.test(t)) hasil.push('telur');
  if (/susu|butter|mentega|keju|wysman|cream|krim/.test(t)) hasil.push('susu');
  if (/kacang|\bmente\b|\bmete\b|kenari|almond/.test(t)) hasil.push('kacang');
  return hasil;
}

const fotoBase = (import.meta.env?.PUBLIC_FOTO_BASE ?? '').replace(/\/$/, '');

function buatFoto(nama: string, files: string[], kategori: KategoriId): Foto[] {
  const label = kategori === 'kue-kering'
    ? ['Close-up tekstur', 'Dalam toples', 'Tersusun di meja']
    : kategori === 'hampers' ? ['Hampers tampak depan', 'Isi hampers', 'Detail kemasan']
    : ['Tampak utuh', 'Potongan / detail', 'Penyajian'];
  const n = Math.max(3, fotoBase ? files.length : 0);
  return Array.from({ length: n }, (_, i) => ({
    src: fotoBase && files[i] ? `${fotoBase}/${files[i]}` : null,
    alt: `${nama} Teratai Cookies, ${label[i % label.length].toLowerCase()}`,
    label: label[i % label.length],
  }));
}

const tersembunyi = (nama: string) => SEMBUNYIKAN_POLA.some((p) => p.test(nama));

/** Menentukan kemasan kue kering: "Keju Kecil" di Toples Tabung = rasa Keju, kemasan Toples Tabung Kecil. */
function pecahRasaKemasan(b: BarisKue): { rasa: string; kemasan: string } {
  let nama = b.nama.trim().replace(/\s+/g, ' ');
  let kemasan = b.kemasan;
  if (kemasan === 'Toples Tabung' && /\skecil$/i.test(nama)) {
    nama = nama.replace(/\skecil$/i, '');
    kemasan = 'Toples Tabung Kecil';
  }
  const rasa = ALIAS_RASA[nama.toLowerCase()] ?? titleCase(nama);
  return { rasa, kemasan };
}

function teksProduk(slug: string, deskripsiDb: string) {
  const k = KONTEN_PRODUK[slug];
  const deskripsi = k?.deskripsi ?? deskripsiDb;
  const ringkas = k?.ringkas ?? (deskripsi.split(/(?<=\.)\s/)[0] || '').slice(0, 120);
  return { deskripsi, ringkas };
}

function musimProduk(nama: string, kategori: KategoriId): MusimId[] {
  const m = new Set<MusimId>();
  for (const { pola, musim } of MUSIM_DARI_NAMA) if (pola.test(nama)) m.add(musim);
  if (kategori === 'kue-kering') {
    for (const [musim, daftar] of Object.entries(RASA_MUSIMAN)) if (daftar.includes(nama)) m.add(musim as MusimId);
  }
  return [...m];
}

function rentang(varian: Varian[]) {
  const h = varian.map((v) => v.harga).filter((x): x is number => x != null && x > 0);
  return { hargaMulai: h.length ? Math.min(...h) : null, hargaTertinggi: h.length ? Math.max(...h) : null };
}

export function bangunKatalog(rows: BarisKue[]): Produk[] {
  const hasil: Produk[] = [];
  const urutId = [...rows].sort((a, b) => a.id - b.id);

  // 1. Kue kering: kelompokkan per rasa, kemasan menjadi varian.
  const grup = new Map<string, { rasa: string; baris: { b: BarisKue; kemasan: string }[] }>();
  for (const b of urutId) {
    if (!(b.kemasan in KEMASAN_KUE_KERING) || tersembunyi(b.nama) || !(b.harga > 0)) continue;
    const { rasa, kemasan } = pecahRasaKemasan(b);
    const key = rasa.toLowerCase();
    if (!grup.has(key)) grup.set(key, { rasa, baris: [] });
    grup.get(key)!.baris.push({ b, kemasan });
  }
  for (const { rasa, baris } of grup.values()) {
    const tampil = RASA_WAJIB_TAMPIL.includes(rasa) || baris.some((x) => x.b.tampil);
    const sudah = new Set<string>();
    const varian: Varian[] = [];
    for (const { b, kemasan } of baris.sort((x, y) => KEMASAN_KUE_KERING[x.kemasan].urut - KEMASAN_KUE_KERING[y.kemasan].urut)) {
      if (sudah.has(kemasan)) continue; // duplikat rasa+kemasan: ambil id terlama
      sudah.add(kemasan);
      varian.push({ id: slugify(kemasan), nama: KEMASAN_KUE_KERING[kemasan].label, harga: b.harga, kueId: b.id });
    }
    const utama = baris.find((x) => x.b.kemasan === 'Mika')?.b ?? baris.find((x) => x.b.deskripsi)?.b ?? baris[0].b;
    const denganDeskripsi = baris.find((x) => bersihkanHtml(x.b.deskripsi))?.b;
    const slug = slugify(rasa);
    const komposisi = komposisiValid(utama.komposisi) ?? komposisiValid(baris.map((x) => x.b.komposisi).find((k) => komposisiValid(k)) ?? null);
    const { deskripsi, ringkas } = teksProduk(slug, bersihkanHtml(denganDeskripsi?.deskripsi));
    const files = baris.flatMap((x) => x.b.gambar ?? []);
    hasil.push({
      slug, nama: rasa, kategori: 'kue-kering', labelVarian: 'Kemasan', varian, ...rentang(varian),
      ringkas, deskripsi, komposisi, alergen: deteksiAlergen(`${rasa} ${komposisi ?? ''}`),
      best: FAVORIT.includes(rasa), tampil, peringkat: baris.reduce((s, x) => s + (x.b.terjual || 0), 0),
      foto: buatFoto(rasa, files, 'kue-kering'), musim: musimProduk(rasa, 'kue-kering'),
    });
  }

  // 2. Cake, hampers, snack: satu baris = satu produk (kecuali yang digabung, mis. Chiffon).
  const gabungan = new Map<string, Produk>();
  for (const b of urutId) {
    const kategori = KATEGORI_LAIN[b.kemasan];
    if (!kategori || tersembunyi(b.nama) || !(b.harga > 0)) continue;
    const namaDb = b.nama.trim().replace(/\s+/g, ' ');
    let tampil: boolean;
    if (kategori === 'hampers') tampil = b.harga >= HAMPERS_HARGA_MINIMUM;
    else if (SNACK_SELALU_TAMPIL.includes(b.kemasan)) tampil = true;
    else tampil = !!b.tampil;

    const g = GABUNG_CAKE.find((x) => x.pola.test(namaDb));
    if (g) {
      const slug = slugify(g.nama);
      const v: Varian = { id: slugify(g.varian(namaDb)), nama: g.varian(namaDb), harga: b.harga, kueId: b.id };
      const ada = gabungan.get(slug);
      if (ada) {
        ada.varian.push(v);
        Object.assign(ada, rentang(ada.varian));
        ada.tampil ||= tampil;
        ada.peringkat += b.terjual || 0;
        continue;
      }
      const komposisi = komposisiValid(b.komposisi);
      const { deskripsi, ringkas } = teksProduk(slug, bersihkanHtml(b.deskripsi));
      const p: Produk = {
        slug, nama: g.nama, kategori, labelVarian: g.labelVarian, varian: [v], ...rentang([v]), ringkas, deskripsi,
        komposisi, alergen: deteksiAlergen(`${g.nama} ${komposisi ?? ''}`), best: !!b.best, tampil, peringkat: b.terjual || 0,
        foto: buatFoto(g.nama, b.gambar ?? [], kategori), musim: [],
      };
      gabungan.set(slug, p);
      hasil.push(p);
      continue;
    }

    const nama = NAMA_TAMPIL[namaDb.toLowerCase()] ?? titleCase(namaDb);
    let slug = slugify(nama);
    if (hasil.some((p) => p.slug === slug)) slug = `${slug}-${b.id}`;
    const varian: Varian[] = b.varian?.length
      ? b.varian.map((v) => ({ id: slugify(v.nama), nama: titleCase(v.nama), harga: v.harga ?? b.harga, kueId: b.id }))
      : [{ id: 'standar', nama: 'Standar', harga: b.harga, kueId: b.id }];
    const komposisi = komposisiValid(b.komposisi);
    const { deskripsi, ringkas } = teksProduk(slug, bersihkanHtml(b.deskripsi));
    hasil.push({
      slug, nama, kategori, labelVarian: b.varian?.length ? 'Rasa' : 'Pilihan', varian, ...rentang(varian), ringkas,
      deskripsi, komposisi, alergen: deteksiAlergen(`${nama} ${komposisi ?? ''}`), best: false, tampil,
      peringkat: b.terjual || 0, foto: buatFoto(nama, b.gambar ?? [], kategori), musim: musimProduk(nama, kategori),
      merek: b.kemasan === 'Jalangkote & Lumpia' ? 'Jalangkote Lasinrang' : undefined,
    });
  }

  // Peringkat: ubah total terjual menjadi urutan 1..n (angka penjualan tidak dipublikasikan).
  const urut = [...hasil].sort((a, b) => b.peringkat - a.peringkat);
  urut.forEach((p, i) => (p.peringkat = i + 1));
  return hasil;
}

let cache: Produk[] | null = null;

/** Semua produk yang tampil di website. */
export async function getKatalog(): Promise<Produk[]> {
  if (cache) return cache;
  let rows = (dataLokal as { kue: BarisKue[] }).kue;
  const api = import.meta.env?.ADMIN_API_URL;
  if (api) {
    const res = await fetch(api, { headers: { accept: 'application/json' } });
    if (!res.ok) throw new Error(`Gagal mengambil katalog dari ${api}: ${res.status}`);
    rows = ((await res.json()) as { kue: BarisKue[] }).kue;
  }
  cache = bangunKatalog(rows).filter((p) => p.tampil);
  return cache;
}

export const KATEGORI: { id: KategoriId; nama: string; singkat: string }[] = [
  { id: 'kue-kering', nama: 'Kue Kering', singkat: 'Kue Kering' },
  { id: 'cake', nama: 'Cake & Kue Basah', singkat: 'Cake' },
  { id: 'hampers', nama: 'Hampers', singkat: 'Hampers' },
  { id: 'snack', nama: 'Snack', singkat: 'Snack' },
];

export const namaKategori = (id: KategoriId) => KATEGORI.find((k) => k.id === id)?.nama ?? id;
