import { describe, expect, it } from 'vitest';
import data from '../src/data/katalog-db.json';
import { bangunKatalog, deteksiAlergen } from '../src/lib/katalog';
import type { BarisKue } from '../src/lib/types';

const semua = bangunKatalog((data as { kue: BarisKue[] }).kue);
const tampil = semua.filter((p) => p.tampil);
const cari = (slug: string) => semua.find((p) => p.slug === slug)!;

describe('katalog', () => {
  it('satu rasa = satu produk, kemasan menjadi varian', () => {
    const nastar = cari('nastar');
    expect(tampil.filter((p) => p.nama === 'Nastar')).toHaveLength(1);
    expect(nastar.varian.map((v) => v.nama)).toContain('Mika');
    expect(nastar.varian.map((v) => v.nama)).toContain('Toples Tabung Kecil');
    expect(nastar.varian.find((v) => v.nama === 'Mika')!.harga).toBe(30000);
    expect(nastar.best).toBe(true);
  });
  it('slug unik', () => {
    const s = semua.map((p) => p.slug);
    expect(new Set(s).size).toBe(s.length);
  });
  it('tidak menampilkan tester, bonus, atau harga 0', () => {
    expect(tampil.some((p) => /tester|bonus/i.test(p.nama))).toBe(false);
    expect(tampil.every((p) => p.varian.every((v) => v.harga == null || v.harga > 0))).toBe(true);
  });
  it('chiffon digabung dengan pilihan rasa', () => {
    const c = cari('chiffon-cake-20-cm');
    expect(c.varian.map((v) => v.nama).sort()).toEqual(['Coklat', 'Keju', 'Pandan']);
    expect(c.hargaMulai).toBe(65000);
  });
  it('tidak ada data reseller di katalog', () => {
    expect(JSON.stringify(data)).not.toMatch(/reseller/i);
  });
  it('alergen dari komposisi', () => {
    expect(deteksiAlergen('Mente: Tepung, Gula, Mentega, Telur')).toEqual(['gluten', 'telur', 'susu', 'kacang']);
  });
});

describe('alergen kacang', () => {
  it('mentega bukan kacang', () => {
    expect(deteksiAlergen('Keju: Mentega, Roombutter, Susu')).not.toContain('kacang');
    expect(deteksiAlergen('Mente Keju')).toContain('kacang');
  });
});
