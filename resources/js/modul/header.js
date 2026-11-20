/** Menu HP (buka/tutup) dan garis bawah header saat halaman digulir. */
export function initHeader() {
  const btn = document.querySelector('[data-tombol-menu]');
  const menu = document.querySelector('[data-menu]');
  const header = document.querySelector('[data-header]');
  const setMenu = (buka) => {
    btn?.setAttribute('aria-expanded', String(buka));
    menu?.classList.toggle('terbuka', buka);
    document.documentElement.classList.toggle('kunci-scroll', buka);
  };
  btn?.addEventListener('click', () => setMenu(btn.getAttribute('aria-expanded') !== 'true'));
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') setMenu(false); });
  matchMedia('(min-width: 960px)').addEventListener('change', () => setMenu(false));
  const onScroll = () => header?.classList.toggle('header--gulir', scrollY > 8);
  addEventListener('scroll', onScroll, { passive: true });
  onScroll();
}
