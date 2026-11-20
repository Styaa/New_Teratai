/** Carousel horizontal (scroll-snap), tanpa autoplay. */
export function initRak() {
  document.querySelectorAll('[data-rak]').forEach((rak) => {
    const jalur = rak.querySelector('[data-rak-jalur]');
    const [kiri, kanan] = rak.querySelectorAll('[data-rak-geser]');
    const sinkron = () => {
      kiri.disabled = jalur.scrollLeft < 8;
      kanan.disabled = jalur.scrollLeft + jalur.clientWidth >= jalur.scrollWidth - 8;
    };
    rak.querySelectorAll('[data-rak-geser]').forEach((b) => b.addEventListener('click', () => {
      const kurang = matchMedia('(prefers-reduced-motion: reduce)').matches;
      jalur.scrollBy({ left: Number(b.dataset.rakGeser) * jalur.clientWidth * 0.85, behavior: kurang ? 'auto' : 'smooth' });
    }));
    jalur.addEventListener('scroll', sinkron, { passive: true });
    addEventListener('resize', sinkron);
    sinkron();
  });
}
