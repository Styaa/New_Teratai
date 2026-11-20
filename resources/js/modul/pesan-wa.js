/** Fungsi murni untuk format harga & pesan WhatsApp. Diuji di tests/js/pesan-wa.test.mjs */

export const rupiah = (n) => 'Rp ' + Math.round(n).toLocaleString('id-ID').replace(/,/g, '.');

export const linkWa = (nomor, teks) => `https://wa.me/${String(nomor ?? '').replace(/\D/g, '')}?text=${encodeURIComponent(teks)}`;

export const totalPesanan = (item) => item.reduce((s, i) => s + (i.harga ?? 0) * i.jumlah, 0);

export function formatTanggal(iso) {
  const [y, m, d] = String(iso).split('-').map(Number);
  if (!y || !m || !d) return iso;
  return new Date(Date.UTC(y, m - 1, d)).toLocaleDateString('id-ID', {
    weekday: 'long', day: 'numeric', month: 'long', year: 'numeric', timeZone: 'UTC',
  });
}

/**
 * @param {{item: {nama:string, varian:string, harga:number|null, jumlah:number}[], metode:'ambil'|'antar',
 *          outlet?:string, alamat?:string, tanggal?:string, nama:string, catatan?:string}} p
 */
export function buatPesanWa(p) {
  const baris = ['Halo Teratai Cookies, saya mau pesan:', ''];
  p.item.forEach((i, idx) => {
    const varian = i.varian && i.varian !== 'Standar' ? ` (${i.varian})` : '';
    baris.push(`${idx + 1}. ${i.nama}${varian}`);
    baris.push(i.harga != null
      ? `   ${i.jumlah} x ${rupiah(i.harga)} = ${rupiah(i.harga * i.jumlah)}`
      : `   ${i.jumlah} x (harga mohon dikonfirmasi)`);
  });
  baris.push('', `*Total: ${rupiah(totalPesanan(p.item))}*`);
  if (p.item.some((i) => i.harga == null)) baris.push('_Sebagian harga menunggu konfirmasi admin._');
  baris.push('');
  baris.push(p.metode === 'ambil' ? `Pengambilan: Ambil di ${p.outlet ?? 'outlet'}` : 'Pengambilan: Diantar');
  if (p.metode === 'antar' && p.alamat) baris.push(`Alamat: ${p.alamat}`);
  if (p.tanggal) baris.push(`Tanggal ${p.metode === 'ambil' ? 'ambil' : 'kirim'}: ${formatTanggal(p.tanggal)}`);
  baris.push(`Nama: ${p.nama}`);
  if (p.catatan?.trim()) baris.push(`Catatan: ${p.catatan.trim()}`);
  baris.push('', 'Terima kasih.');
  return baris.join('\n');
}
