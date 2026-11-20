/**
 * Mode musiman. Ganti satu variabel (PUBLIC_MUSIM di .env, atau MUSIM_DEFAULT di bawah)
 * untuk mengganti banner, warna aksen, dan koleksi unggulan tanpa mengubah layout.
 * Pratinjau tanpa build ulang: tambahkan ?musim=lebaran pada URL beranda.
 */
import type { MusimId } from '@/lib/types';

const MUSIM_DEFAULT: MusimId = 'natal';

export interface Musim {
  id: MusimId;
  label: string;
  banner: { eyebrow: string; judul: string; sub: string; cta: string; ctaHref: string };
  koleksi: { judul: string; sub: string };
}

export const DAFTAR_MUSIM: Record<MusimId, Musim> = {
  reguler: {
    id: 'reguler',
    label: 'Reguler',
    banner: {
      eyebrow: 'Hantaran & hampers',
      judul: 'Hadiah manis untuk orang terdekat',
      sub: 'Hampers kue kering untuk kantor, keluarga, dan acara. Isi bisa disesuaikan.',
      cta: 'Lihat Hampers',
      ctaHref: '/hampers/',
    },
    koleksi: { judul: 'Pilihan untuk Hantaran', sub: 'Kue dan hampers yang paling sering dipilih untuk hadiah.' },
  },
  lebaran: {
    id: 'lebaran',
    label: 'Lebaran',
    banner: {
      eyebrow: 'Koleksi Lebaran',
      judul: 'Toples Lebaran sudah bisa dipesan',
      sub: 'Nastar, kastengel, dan kue bangkit untuk meja tamu. Pesan lebih awal agar tanggal ambilmu aman.',
      cta: 'Pesan Kue Lebaran',
      ctaHref: '/hampers/',
    },
    koleksi: { judul: 'Koleksi Lebaran', sub: 'Kue yang selalu ada di meja tamu saat hari raya.' },
  },
  natal: {
    id: 'natal',
    label: 'Natal',
    banner: {
      eyebrow: 'Koleksi Natal',
      judul: 'Kue dan hampers Natal sudah dibuka',
      sub: 'Nastar, tosca khas Manado, dan hampers Natal. Pesan minimal H-3 agar tanggal ambilmu aman.',
      cta: 'Lihat Koleksi Natal',
      ctaHref: '/hampers/',
    },
    koleksi: { judul: 'Koleksi Natal', sub: 'Kue kering dan hampers untuk merayakan Natal bersama keluarga.' },
  },
  imlek: {
    id: 'imlek',
    label: 'Imlek',
    banner: {
      eyebrow: 'Koleksi Imlek',
      judul: 'Hampers Imlek untuk keluarga dan relasi',
      sub: 'Nastar dan kue kering pilihan dalam kemasan Imlek. Pesan minimal H-3.',
      cta: 'Lihat Hampers Imlek',
      ctaHref: '/hampers/',
    },
    koleksi: { judul: 'Koleksi Imlek', sub: 'Nastar, kastengel, dan hampers untuk Tahun Baru Imlek.' },
  },
};

const dariEnv = (import.meta.env?.PUBLIC_MUSIM ?? '') as string;
export const MUSIM_AKTIF: MusimId = dariEnv in DAFTAR_MUSIM ? (dariEnv as MusimId) : MUSIM_DEFAULT;
