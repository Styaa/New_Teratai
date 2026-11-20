/** Fungsi murni untuk format harga & pesan WhatsApp. Dipakai di server dan browser. */

export const rupiah = (n: number) => 'Rp ' + Math.round(n).toLocaleString('id-ID').replace(/,/g, '.');

export const linkWa = (nomor: string, teks: string) =>
  `https://wa.me/${nomor.replace(/\D/g, '')}?text=${encodeURIComponent(teks)}`;

export interface ItemPesanan {
  nama: string;
  varian: string; // kemasan / rasa
  harga: number | null;
  jumlah: number;
}

export interface DataPesanan {
  item: ItemPesanan[];
  metode: 'ambil' | 'antar';
  outlet?: string; // nama outlet bila ambil
  alamat?: string; // bila antar
  tanggal?: string; // yyyy-mm-dd
  nama: string;
  catatan?: string;
}

export const totalPesanan = (item: ItemPesanan[]) =>
  item.reduce((s, i) => s + (i.harga ?? 0) * i.jumlah, 0);

export function formatTanggal(iso: string) {
  const [y, m, d] = iso.split('-').map(Number);
  if (!y || !m || !d) return iso;
  const tgl = new Date(Date.UTC(y, m - 1, d));
  return tgl.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric', timeZone: 'UTC' });
}

export function buatPesanWa(p: DataPesanan): string {
  const baris: string[] = ['Halo Teratai Cookies, saya mau pesan:', ''];
  p.item.forEach((i, idx) => {
    const varian = i.varian && i.varian !== 'Standar' ? ` (${i.varian})` : '';
    baris.push(`${idx + 1}. ${i.nama}${varian}`);
    baris.push(
      i.harga != null
        ? `   ${i.jumlah} x ${rupiah(i.harga)} = ${rupiah(i.harga * i.jumlah)}`
        : `   ${i.jumlah} x (harga mohon dikonfirmasi)`,
    );
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
