import { buatPesanWa, linkWa, rupiah, totalPesanan } from './pesan-wa';
/**
 * Keranjang ringan di browser (localStorage). Checkout = membuka WhatsApp dengan pesan terisi.
 * API: window.dispatchEvent(new CustomEvent('keranjang:tambah', { detail: {slug, nama, varianId, varian, harga, jumlah, buka} }))
 */
export function initKeranjang() {
    const KUNCI = 'teratai-keranjang-v1';
    const MAKS = 99;

    const baca = () => {
        try {
            const d = JSON.parse(localStorage.getItem(KUNCI) ?? '[]');
            return Array.isArray(d) ? d.filter((i) => i && i.slug && i.jumlah > 0) : [];
        } catch {
            return [];
        }
    };
    let item = baca();
    const simpan = () => {
        try {
            localStorage.setItem(KUNCI, JSON.stringify(item));
        } catch {
            /* mode privat */
        }
    };

    const laci = document.querySelector('[data-laci]');
    if (!laci) return;
    const konfig = JSON.parse(laci.dataset.konfig ?? '{}');
    const daftar = laci.querySelector('[data-laci-daftar]');
    const kosong = laci.querySelector('[data-laci-kosong]');
    const kaki = laci.querySelector('[data-laci-kaki]');
    const form = laci.querySelector('[data-form-checkout]');
    const elTotal = laci.querySelector('[data-laci-total]');
    const elCatatanHarga = laci.querySelector('[data-laci-catatan-harga]');
    const inputTanggal = form.querySelector('[name=tanggal]');

    const esc = (s) =>
        s.replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[c]);
    const kunci = (i) => `${i.slug}:${i.varianId}`;
    const hariIni = () => {
        const d = new Date();
        d.setMinutes(d.getMinutes() - d.getTimezoneOffset());
        return d.toISOString().slice(0, 10);
    };

    function render() {
        const n = item.reduce((s, i) => s + i.jumlah, 0);
        document.querySelectorAll('[data-jumlah-keranjang]').forEach((el) => {
            el.textContent = String(n);
            el.hidden = n === 0;
        });
        document
            .querySelectorAll('[data-buka-keranjang]')
            .forEach((b) => b.setAttribute('aria-label', n ? `Buka pesanan, ${n} item` : 'Buka pesanan'));

        const ada = item.length > 0;
        kosong.hidden = ada;
        form.hidden = !ada;
        kaki.hidden = !ada;
        daftar.innerHTML = item
            .map(
                (i) => `
    <li class="item-laci" data-kunci="${esc(kunci(i))}">
      <div>
        <div class="item-laci__nama">${esc(i.nama)}</div>
        ${i.varian && i.varian !== 'Standar' ? `<div class="item-laci__varian">${esc(i.varian)}</div>` : ''}
      </div>
      <div class="item-laci__subtotal harga">${i.harga != null ? rupiah(i.harga * i.jumlah) : 'Dikonfirmasi'}</div>
      <div class="item-laci__baris">
        <div class="stepper stepper--kecil" role="group" aria-label="Jumlah ${esc(i.nama)}">
          <button type="button" data-ubah="-1" aria-label="Kurangi">−</button>
          <output class="angka" aria-live="polite">${i.jumlah}</output>
          <button type="button" data-ubah="1" aria-label="Tambah">+</button>
        </div>
        <button type="button" class="item-laci__hapus" data-hapus>Hapus</button>
      </div>
    </li>`,
            )
            .join('');
        elTotal.textContent = rupiah(totalPesanan(item));
        elCatatanHarga.hidden = !item.some((i) => i.harga == null);
    }

    function tambah(baru) {
        const ada = item.find((i) => kunci(i) === kunci(baru));
        if (ada) ada.jumlah = Math.min(MAKS, ada.jumlah + baru.jumlah);
        else item.push({ ...baru, jumlah: Math.min(MAKS, Math.max(1, baru.jumlah)) });
        simpan();
        render();
    }

    daftar.addEventListener('click', (e) => {
        const t = e.target;
        const li = t.closest('[data-kunci]');
        if (!li) return;
        const idx = item.findIndex((i) => kunci(i) === li.dataset.kunci);
        if (idx < 0) return;
        const ubah = t.closest('[data-ubah]');
        if (ubah) {
            item[idx].jumlah = Math.min(MAKS, item[idx].jumlah + Number(ubah.dataset.ubah));
            if (item[idx].jumlah <= 0) item.splice(idx, 1);
        } else if (t.closest('[data-hapus]')) {
            item.splice(idx, 1);
        } else return;
        simpan();
        render();
        // jaga fokus tetap di dalam daftar setelah render ulang
        const sama = daftar.querySelector(
            `[data-kunci="${CSS.escape(li.dataset.kunci)}"] ${ubah ? `[data-ubah="${ubah.dataset.ubah}"]` : ''}`,
        );
        (sama ?? laci.querySelector('[data-tutup-laci]'))?.focus();
    });

    // Cara terima: tampilkan alamat bila diantar
    const sinkronMetode = () => {
        const v = form.querySelector('[name=terima]:checked')?.value ?? '';
        const antar = v === 'antar';
        laci.querySelector('[data-bidang-alamat]').hidden = !antar;
        laci.querySelector('[data-label-tanggal]').textContent = antar ? 'Tanggal kirim' : 'Tanggal ambil';
    };
    form.addEventListener('change', sinkronMetode);
    // hapus pesan galat begitu bidang diperbaiki
    form.addEventListener('input', (e) => {
        const el = e.target;
        if (el.name && el.getAttribute('aria-invalid') === 'true' && el.value.trim()) galat(el.name, false);
    });

    const galat = (nama, tampil) => {
        const el = form.querySelector(`[data-galat="${nama}"]`);
        const input = form.querySelector(`[name="${nama}"]`);
        if (el) el.hidden = !tampil;
        input?.setAttribute('aria-invalid', String(tampil));
        if (input && el) {
            el.id ||= `galat-${nama}`;
            input.setAttribute('aria-describedby', el.id);
        }
    };

    laci.querySelector('[data-kirim-wa]').addEventListener('click', (e) => {
        e.preventDefault();
        const fd = new FormData(form);
        const terima = String(fd.get('terima') ?? '');
        const antar = terima === 'antar';
        const outlet = konfig.outlet.find((o) => `ambil:${o.id}` === terima);
        const nama = String(fd.get('nama') ?? '').trim();
        const tanggal = String(fd.get('tanggal') ?? '');
        const alamat = String(fd.get('alamat') ?? '').trim();

        const salah = { nama: !nama, tanggal: !tanggal || tanggal < hariIni(), alamat: antar && !alamat };
        Object.entries(salah).forEach(([k, v]) => galat(k, v));
        const pertama = Object.entries(salah).find(([, v]) => v)?.[0];
        if (pertama) {
            form.querySelector(`[name="${pertama}"]`)?.focus();
            return;
        }

        const teks = buatPesanWa({
            item,
            metode: antar ? 'antar' : 'ambil',
            outlet: outlet?.nama,
            alamat,
            tanggal,
            nama,
            catatan: String(fd.get('catatan') ?? ''),
        });
        const nomor = outlet?.wa || konfig.waUtama || '';
        window.open(linkWa(nomor, teks), '_blank', 'noopener');
    });

    // Buka / tutup
    const buka = () => {
        render();
        inputTanggal.min = hariIni();
        sinkronMetode();
        if (!laci.open) laci.showModal();
    };
    document.addEventListener('click', (e) => {
        if (e.target.closest('[data-buka-keranjang]')) {
            e.preventDefault();
            buka();
        }
    });
    laci.querySelector('[data-tutup-laci]').addEventListener('click', () => laci.close());
    laci.addEventListener('click', (e) => {
        if (e.target === laci) laci.close();
    }); // klik backdrop

    window.addEventListener('keranjang:tambah', (e) => {
        tambah(e.detail);
        if (e.detail.buka) buka();
    });
    window.addEventListener('storage', (e) => {
        if (e.key === KUNCI) {
            item = baca();
            render();
        }
    });

    render();
}
