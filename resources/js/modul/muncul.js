/** Animasi masuk ringan. Dimatikan otomatis oleh prefers-reduced-motion. */
export function initMuncul() {
  const el = document.querySelectorAll('.muncul');
  if ('IntersectionObserver' in window && !matchMedia('(prefers-reduced-motion: reduce)').matches) {
    const io = new IntersectionObserver((entri) => entri.forEach((e) => {
      if (e.isIntersecting) { e.target.classList.add('terlihat'); io.unobserve(e.target); }
    }), { rootMargin: '0px 0px -8% 0px' });
    el.forEach((e) => io.observe(e));
  } else {
    el.forEach((e) => e.classList.add('terlihat'));
  }
}
