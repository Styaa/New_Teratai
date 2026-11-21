import { buatPesanLangsung, linkWa, rupiah } from './pesan-wa';

/** Halaman detail: galeri foto + pemilih kemasan (harga berubah) + tambah ke pesanan. */
export function initDetail() {
  document.querySelectorAll('[data-galeri]').forEach((g) => {
    const slides = g.querySelectorAll('[data-slide]');
    const thumbs = g.querySelectorAll('[data-thumb]');
    thumbs.forEach((t) => t.addEventListener('click', () => {
      slides.forEach((s) => (s.hidden = s.dataset.slide !== t.dataset.thumb));
      thumbs.forEach((x) => x.setAttribute('aria-pressed', String(x === t)));
    }));
  });

  document.querySelectorAll('[data-pemilih]').forEach((form) => {
    const tampilHarga = form.querySelector('[data-harga-tampil]');
    const tampilVarian = form.querySelector('[data-varian-tampil]');
    const jumlah = form.querySelector('[name=jumlah]');
    const status = form.querySelector('[data-status]');
    const terpilih = () => form.querySelector('[name=varian]:checked') ?? form.querySelector('input[type=hidden][name=varian]');
    const hargaDari = (el) => (el.dataset.harga ? Number(el.dataset.harga) : null);
    const n = () => Math.min(99, Math.max(1, Math.floor(Number(jumlah.value) || 1)));

    const perbarui = () => {
      const v = terpilih();
      const h = hargaDari(v);
      const teks = h == null ? 'Tanya harga' : rupiah(h * n());
      if (tampilHarga.textContent !== teks) {
        tampilHarga.textContent = teks;
        tampilHarga.classList.remove('ganti');
        void tampilHarga.offsetWidth; // ulang animasi
        tampilHarga.classList.add('ganti');
      }
      if (tampilVarian) tampilVarian.textContent = `(${v.dataset.label}${n() > 1 ? ` × ${n()}` : ''})`;
    };
    form.addEventListener('change', perbarui);
    jumlah.addEventListener('input', perbarui);
    jumlah.addEventListener('blur', () => { jumlah.value = String(n()); perbarui(); });
    form.querySelectorAll('[data-langkah]').forEach((b) => b.addEventListener('click', () => {
      jumlah.value = String(Math.min(99, Math.max(1, n() + Number(b.dataset.langkah))));
      perbarui();
    }));
    const itemTerpilih = () => {
      const v = terpilih();
      return { nama: form.dataset.nama, varian: v.dataset.label, harga: hargaDari(v), jumlah: n() };
    };
    form.querySelector('[data-pesan-langsung]')?.addEventListener('click', () => {
      window.open(linkWa(form.dataset.wa ?? '', buatPesanLangsung(itemTerpilih())), '_blank', 'noopener');
    });
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const v = terpilih();
      window.dispatchEvent(new CustomEvent('keranjang:tambah', {
        detail: { slug: form.dataset.slug, nama: form.dataset.nama, varianId: v.value, varian: v.dataset.label, harga: hargaDari(v), jumlah: n(), buka: true },
      }));
      status.textContent = `${form.dataset.nama} (${v.dataset.label}) × ${n()} ditambahkan ke pesanan.`;
      const tombol = form.querySelector('button[type=submit]');
      if (tombol && !tombol.dataset.teks) {
        tombol.dataset.teks = tombol.innerHTML;
        tombol.textContent = '✓ Ditambahkan';
        setTimeout(() => { tombol.innerHTML = tombol.dataset.teks; delete tombol.dataset.teks; }, 1600);
      }
    });
    perbarui();
  });
}
