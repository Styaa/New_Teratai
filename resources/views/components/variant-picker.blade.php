{{--
  Pemilih kemasan (daftar baris: nama kiri, harga kanan) + jumlah + dua aksi:
  "Pesan via WhatsApp" (langsung item ini) dan "Tambah ke Pesanan" (keranjang). Logika: resources/js/modul/detail.js
--}}
@props(['produk'])
@php
    $p = $produk;
    $awal = $p->varian[0];
    $tunggal = count($p->varian) === 1;
    $labelHarga = fn ($h) => $h === null ? 'Tanya harga' : rupiah($h);
@endphp
<form class="varian" data-pemilih data-slug="{{ $p->slug }}" data-nama="{{ $p->nama }}" data-wa="{{ config('teratai.whatsapp') }}">
    <p class="varian__harga harga" aria-live="polite">
        <span data-harga-tampil>{{ $labelHarga($awal['harga']) }}</span>
        @unless ($tunggal)<span class="varian__harga-ket" data-varian-tampil>({{ $awal['nama'] }})</span>@endunless
    </p>

    @if ($tunggal)
        <input type="hidden" name="varian" value="{{ $awal['id'] }}" data-harga="{{ $awal['harga'] }}" data-label="{{ $awal['nama'] }}">
    @else
        <fieldset class="varian__grup">
            <legend class="label">Pilihan {{ mb_strtolower($p->labelVarian) }}</legend>
            <div class="varian__daftar">
                @foreach ($p->varian as $v)
                    <label class="varian__item">
                        <input type="radio" name="varian" value="{{ $v['id'] }}" @checked($loop->first) data-harga="{{ $v['harga'] }}" data-label="{{ $v['nama'] }}">
                        <span>{{ $v['nama'] }}</span>
                        <span class="harga">{{ $labelHarga($v['harga']) }}</span>
                    </label>
                @endforeach
            </div>
        </fieldset>
    @endif

    <div class="varian__jumlah">
        <label for="jumlah-{{ $p->slug }}" class="label">Jumlah</label>
        <div class="stepper">
            <button type="button" data-langkah="-1" aria-label="Kurangi jumlah">−</button>
            <input id="jumlah-{{ $p->slug }}" name="jumlah" type="number" inputmode="numeric" min="1" max="99" value="1" class="angka">
            <button type="button" data-langkah="1" aria-label="Tambah jumlah">+</button>
        </div>
    </div>

    <div class="varian__aksi">
        <button type="button" class="btn btn--penuh" data-pesan-langsung><x-icon nama="whatsapp" /> Pesan via WhatsApp</button>
        <button type="submit" class="btn btn--garis btn--penuh">Tambah ke Pesanan</button>
    </div>
    <p class="varian__status" role="status" data-status></p>
</form>
