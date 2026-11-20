/** Halaman /produk: filter kategori, pencarian, dan urutan (tanpa reload). */
export function initKatalog() {
  const grid = document.querySelector('[data-grid]');
  if (!grid) return;
  const kartu = [...grid.querySelectorAll('[data-kartu]')];
  const cari = document.querySelector('[data-cari]');
  const urut = document.querySelector('[data-urut]');
  const chips = [...document.querySelectorAll('.tab[data-kategori]')];
  const info = document.querySelector('[data-info]');
  const kosong = document.querySelector('[data-kosong]');

  const norm = (s) => s.toLowerCase().normalize('NFKD').replace(/[^\w\s]/g, '').trim();
  const params = new URLSearchParams(location.search);
  let kategori = params.get('kategori') ?? '';
  cari.value = params.get('q') ?? '';
  if (params.get('urut')) urut.value = params.get('urut');
  if (!chips.some((c) => c.dataset.kategori === kategori)) kategori = '';

  const nama = (el) => el.querySelector('a')?.textContent ?? '';
  const pembanding = {
    'terlaris': (a, b) => Number(b.dataset.best) - Number(a.dataset.best) || Number(a.dataset.peringkat) - Number(b.dataset.peringkat),
    'harga-naik': (a, b) => Number(a.dataset.harga) - Number(b.dataset.harga),
    'harga-turun': (a, b) => Number(b.dataset.harga) - Number(a.dataset.harga),
    'nama': (a, b) => nama(a).localeCompare(nama(b), 'id'),
  };

  function terapkan(simpanUrl = true) {
    const q = norm(cari.value);
    const kata = q.split(/\s+/).filter(Boolean);
    let n = 0;
    kartu.sort(pembanding[urut.value] ?? pembanding.terlaris).forEach((k) => {
      const cocok = (!kategori || k.dataset.kategori === kategori) && kata.every((w) => norm(k.dataset.nama ?? '').includes(w));
      k.hidden = !cocok;
      if (cocok) n++;
      grid.appendChild(k);
    });
    chips.forEach((c) => c.setAttribute('aria-pressed', String(c.dataset.kategori === kategori)));
    info.textContent = `${n} produk${q ? ` untuk “${cari.value.trim()}”` : ''}`;
    kosong.hidden = n > 0;
    if (simpanUrl) {
      const p = new URLSearchParams();
      if (kategori) p.set('kategori', kategori);
      if (q) p.set('q', cari.value.trim());
      if (urut.value !== 'terlaris') p.set('urut', urut.value);
      history.replaceState(null, '', `${location.pathname}${p.size ? `?${p}` : ''}`);
    }
  }

  chips.forEach((c) => c.addEventListener('click', () => { kategori = c.dataset.kategori ?? ''; terapkan(); }));
  let t;
  cari.addEventListener('input', () => { clearTimeout(t); t = setTimeout(terapkan, 120); });
  urut.addEventListener('change', () => terapkan());
  document.querySelector('[data-reset]')?.addEventListener('click', () => { kategori = ''; cari.value = ''; terapkan(); cari.focus(); });
  terapkan(false);
}
