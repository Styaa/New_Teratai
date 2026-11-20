import { describe, expect, it } from 'vitest';
import { buatPesanWa, linkWa, rupiah, totalPesanan } from '../src/lib/pesan-wa';

describe('pesan WhatsApp', () => {
  const item = [
    { nama: 'Nastar', varian: 'Toples Bulat', harga: 90000, jumlah: 2 },
    { nama: 'Hampers Box', varian: 'Standar', harga: null, jumlah: 1 },
  ];
  it('format rupiah', () => {
    expect(rupiah(1234567)).toBe('Rp 1.234.567');
    expect(rupiah(0)).toBe('Rp 0');
  });
  it('total mengabaikan harga yang belum dikonfirmasi', () => {
    expect(totalPesanan(item)).toBe(180000);
  });
  it('pesan ambil di outlet berisi item, subtotal, total, outlet, tanggal, nama', () => {
    const t = buatPesanWa({ item, metode: 'ambil', outlet: 'Teratai Pelita', tanggal: '2026-12-20', nama: 'Ani', catatan: 'Kartu ucapan' });
    expect(t).toContain('1. Nastar (Toples Bulat)');
    expect(t).toContain('2 x Rp 90.000 = Rp 180.000');
    expect(t).toContain('2. Hampers Box\n   1 x (harga mohon dikonfirmasi)');
    expect(t).toContain('*Total: Rp 180.000*');
    expect(t).toContain('Sebagian harga menunggu konfirmasi admin');
    expect(t).toContain('Pengambilan: Ambil di Teratai Pelita');
    expect(t).toContain('Tanggal ambil: Minggu, 20 Desember 2026');
    expect(t).toContain('Nama: Ani');
    expect(t).toContain('Catatan: Kartu ucapan');
  });
  it('pesan diantar berisi alamat', () => {
    const t = buatPesanWa({ item: item.slice(0, 1), metode: 'antar', alamat: 'Jl. A No. 1', tanggal: '2026-12-20', nama: 'Ani' });
    expect(t).toContain('Pengambilan: Diantar\nAlamat: Jl. A No. 1');
    expect(t).toContain('Tanggal kirim:');
    expect(t).not.toContain('Catatan:');
  });
  it('link wa: nomor kosong membuka pemilih kontak', () => {
    expect(linkWa('', 'hai')).toBe('https://wa.me/?text=hai');
    expect(linkWa('+62 812-3456', 'a b')).toBe('https://wa.me/628123456?text=a%20b');
  });
});
