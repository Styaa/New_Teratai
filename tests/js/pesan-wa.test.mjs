import assert from 'node:assert/strict';
import { test } from 'node:test';
import { buatPesanWa, linkWa, rupiah, totalPesanan } from '../../resources/js/modul/pesan-wa.js';

const item = [
  { nama: 'Nastar', varian: 'Toples Bulat', harga: 90000, jumlah: 2 },
  { nama: 'Hampers Box', varian: 'Standar', harga: null, jumlah: 1 },
];

test('format rupiah', () => {
  assert.equal(rupiah(1234567), 'Rp 1.234.567');
  assert.equal(rupiah(0), 'Rp 0');
});

test('total mengabaikan harga yang belum dikonfirmasi', () => {
  assert.equal(totalPesanan(item), 180000);
});

test('pesan ambil di outlet', () => {
  const t = buatPesanWa({ item, metode: 'ambil', outlet: 'Teratai Pelita', tanggal: '2026-12-20', nama: 'Ani', catatan: 'Kartu ucapan' });
  assert.match(t, /1\. Nastar \(Toples Bulat\)\n   2 x Rp 90\.000 = Rp 180\.000/);
  assert.match(t, /2\. Hampers Box\n   1 x \(harga mohon dikonfirmasi\)/);
  assert.match(t, /\*Total: Rp 180\.000\*/);
  assert.match(t, /Sebagian harga menunggu konfirmasi admin/);
  assert.match(t, /Pengambilan: Ambil di Teratai Pelita/);
  assert.match(t, /Tanggal ambil: Minggu, 20 Desember 2026/);
  assert.match(t, /Nama: Ani/);
  assert.match(t, /Catatan: Kartu ucapan/);
});

test('pesan diantar berisi alamat', () => {
  const t = buatPesanWa({ item: item.slice(0, 1), metode: 'antar', alamat: 'Jl. A No. 1', tanggal: '2026-12-20', nama: 'Ani' });
  assert.match(t, /Pengambilan: Diantar\nAlamat: Jl\. A No\. 1/);
  assert.match(t, /Tanggal kirim:/);
  assert.doesNotMatch(t, /Catatan:/);
});

test('link wa: nomor kosong membuka pemilih kontak', () => {
  assert.equal(linkWa('', 'hai'), 'https://wa.me/?text=hai');
  assert.equal(linkWa('+62 812-3456', 'a b'), 'https://wa.me/628123456?text=a%20b');
});

test('pesan langsung satu item dari halaman produk', async () => {
  const { buatPesanLangsung } = await import('../../resources/js/modul/pesan-wa.js');
  const t = buatPesanLangsung({ nama: 'Nastar', varian: 'Toples Bulat', harga: 90000, jumlah: 2 });
  assert.match(t, /Nastar \(Toples Bulat\)\n2 x Rp 90\.000 = Rp 180\.000/);
  assert.match(t, /Mohon info ketersediaan/);
});
