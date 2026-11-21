/**
 * Motion ringan tanpa library:
 *  1. Reveal saat digulir (sekali jalan, berurutan per baris)
 *  2. Morph foto produk dari kartu → halaman detail (View Transitions lintas halaman, bila didukung)
 * Semua dimatikan bila pengguna memilih "kurangi gerakan".
 */
export const kurangiGerak = () => matchMedia('(prefers-reduced-motion: reduce)').matches;

// Elemen yang ikut reveal. Tidak perlu menandai satu per satu di view.
const TARGET = [
  '.kepala-bagian', '.keunggulan > li', '.grid-produk > .kartu', '.rak__jalur > .kartu', '.sorotan > *',
  '.testimoni > li', '.grid-outlet > .outlet', '.keluarga > li', '.penutup > .wadah', '.langkah > li',
  '.daftar-info', '.panel-form', '.proses > li', '.tim > figure', '.faq__grup', '.prosa', '.catatan',
].join(',');

function initReveal() {
  if (kurangiGerak() || !('IntersectionObserver' in window)) return;
  const io = new IntersectionObserver((entri) => {
    for (const e of entri) {
      if (!e.isIntersecting) continue;
      e.target.classList.add('terlihat');
      io.unobserve(e.target);
    }
  }, { rootMargin: '0px 0px -6% 0px', threshold: 0.08 });

  const batas = innerHeight;
  const semua = [...document.querySelectorAll(TARGET)];
  // Baca semua posisi & lebar sekali (tanpa bolak-balik baca/tulis layout).
  const ukur = semua.map((el) => ({ el, atas: el.getBoundingClientRect().top, lebar: el.clientWidth, induk: el.parentElement }));
  const kolomPerInduk = new Map();
  const urutan = new Map();
  for (const u of ukur) {
    if (!kolomPerInduk.has(u.induk)) kolomPerInduk.set(u.induk, Math.max(1, Math.round(u.induk.clientWidth / Math.max(1, u.lebar))));
    const n = urutan.get(u.induk) ?? 0;
    urutan.set(u.induk, n + 1);
    u.indeks = n;
  }
  for (const { el, atas, induk, indeks } of ukur) {
    // Elemen di layar pertama dibiarkan apa adanya: tidak berkedip, tidak memperlambat LCP.
    if (atas < batas) continue;
    // Urutan dalam satu baris grid → jeda bertahap (maks 3 langkah).
    el.style.setProperty('--i', String(Math.min(indeks % kolomPerInduk.get(induk), 3)));
    el.classList.add('muncul');
    io.observe(el);
  }
}

/** Foto kartu "terbang" ke foto besar di halaman detail, dan sebaliknya saat kembali. */
function initMorphFoto() {
  if (kurangiGerak()) return;
  const NAMA = 'foto-produk';
  const fotoKartu = (a) => a.closest('.kartu')?.querySelector('.kartu__foto');

  // Maju: beri nama hanya pada kartu yang diklik (nama harus unik per halaman).
  document.addEventListener('click', (e) => {
    const a = e.target.closest('.kartu__tautan');
    if (!a || e.metaKey || e.ctrlKey || e.shiftKey || e.button !== 0) return;
    document.querySelectorAll('.kartu__foto').forEach((f) => (f.style.viewTransitionName = ''));
    const f = fotoKartu(a);
    if (f) f.style.viewTransitionName = NAMA;
  });

  // Kembali dari detail: cari kartu produk yang tadi dibuka, beri nama sementara.
  addEventListener('pagereveal', (e) => {
    if (!e.viewTransition) return;
    const dari = navigation?.activation?.from?.url;
    const m = dari && new URL(dari).pathname.match(/^\/produk\/([a-z0-9-]+)$/);
    if (!m || document.querySelector('.detail__utama')) return;
    const a = document.querySelector(`.kartu__tautan[href$="/produk/${m[1]}"]`);
    const f = a && fotoKartu(a);
    if (!f) return;
    f.style.viewTransitionName = NAMA;
    e.viewTransition.finished.finally(() => (f.style.viewTransitionName = ''));
  });

  // Halaman yang dipulihkan dari bfcache: bersihkan nama yang tertinggal.
  addEventListener('pageshow', () => document.querySelectorAll('.kartu__foto').forEach((f) => (f.style.viewTransitionName = '')));
}

export function initMotion() {
  initReveal();
  initMorphFoto();
}
