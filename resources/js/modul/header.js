/** Menu HP (buka/tutup) dan garis bawah header saat halaman digulir. */
export function initHeader() {
  const btn = document.querySelector('[data-tombol-menu]');
  const menu = document.querySelector('[data-menu]');
  const header = document.querySelector('[data-header]');
  const setMenu = (buka) => {
    btn?.setAttribute('aria-expanded', String(buka));
    menu?.classList.toggle('terbuka', buka);
    if (buka) header?.classList.remove('header--sembunyi');
    document.documentElement.classList.toggle('kunci-scroll', buka);
  };
  btn?.addEventListener('click', () => setMenu(btn.getAttribute('aria-expanded') !== 'true'));
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') setMenu(false); });
  matchMedia('(min-width: 960px)').addEventListener('change', () => setMenu(false));
  let terakhir = scrollY;
  const onScroll = () => {
    const y = scrollY;
    header?.classList.toggle('header--gulir', y > 8);
    // Sembunyikan saat menggulir ke bawah (lewat 240 px), tampilkan lagi saat menggulir ke atas.
    const turun = y > terakhir + 4;
    const naik = y < terakhir - 4;
    if (turun && y > 240 && !menu?.classList.contains('terbuka')) header?.classList.add('header--sembunyi');
    else if (naik || y < 240) header?.classList.remove('header--sembunyi');
    if (turun || naik) terakhir = y;
  };
  addEventListener('scroll', onScroll, { passive: true });
  onScroll();
}
