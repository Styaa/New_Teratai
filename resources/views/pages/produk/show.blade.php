@php
    $namaKategori = config("katalog.kategori.{$p->kategori}");
    $semuaAlergen = ['kacang' => 'Kacang', 'susu' => 'Susu', 'telur' => 'Telur', 'gluten' => 'Gluten (terigu)'];
    $judul = $p->kategori === 'kue-kering' ? "Kue {$p->nama} Makassar" : "{$p->nama} Makassar";
    $deskripsiMeta = \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ',
        "{$p->nama} dari Teratai Cookies Makassar. {$p->ringkas} ".($p->hargaMulai() ? 'Mulai '.rupiah($p->hargaMulai()).'.' : '').' Pesan via WhatsApp, ambil di Pelita atau Hertasning.')), 157, '');
    $outletSingkat = collect(config('teratai.outlet'))->map(fn ($o) => str_replace('Teratai ', '', $o['nama']))->join(' atau ');
    $paragraf = array_values(array_filter(explode("\n", $p->deskripsi)));
@endphp
<x-layouts.app hal="detail" :judul="$judul" :deskripsi="$deskripsiMeta" :json-ld="\App\Support\Seo::produk($p)" tipe-og="product">
    <x-jejak :jejak="[
        ['nama' => 'Produk', 'url' => route('produk.index')],
        ['nama' => $namaKategori, 'url' => route('produk.index', ['kategori' => $p->kategori])],
        ['nama' => $p->nama, 'url' => $p->url()],
    ]" />

    <div class="wadah">
        <a class="kembali" href="{{ route('produk.index') }}"><x-icon nama="kiri" /> Katalog</a>
    </div>

    <article class="wadah detail">
        <div class="detail__galeri" data-galeri>
            <div class="detail__utama">
                @foreach ($p->foto as $i => $f)
                    <div class="detail__slide" data-slide="{{ $i }}" @if ($i > 0) hidden @endif>
                        <x-foto :foto="$f" :jenis="$i === 0 ? $p->jenisFoto() : 'kue'" rasio="1 / 1" :eager="$i === 0" sizes="(min-width: 900px) 530px, 100vw" />
                    </div>
                @endforeach
            </div>
            @if (count($p->foto) > 1)
                <div class="detail__thumbs" role="group" aria-label="Pilih foto">
                    @foreach ($p->foto as $i => $f)
                        <button type="button" class="detail__thumb" aria-pressed="{{ $i === 0 ? 'true' : 'false' }}" aria-label="Foto {{ $i + 1 }}: {{ $f['label'] }}" data-thumb="{{ $i }}">
                            <x-foto :foto="$f" :jenis="$i === 0 ? $p->jenisFoto() : 'kue'" rasio="1 / 1" :label="false" sizes="100px" />
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="detail__info">
            <span class="label">{{ $p->merek ?? $namaKategori }}@if ($p->best) &nbsp;·&nbsp; <span class="favorit">Favorit</span>@endif</span>
            <h1>{{ $p->nama }}</h1>
            <p class="detail__ringkas">{{ $p->ringkas }}</p>

            <x-variant-picker :produk="$p" />

            <ul class="info-singkat">
                <li><x-icon nama="toko" /> Ambil di outlet {{ $outletSingkat }}</li>
                <li><x-icon nama="truk" /> Bisa diantar, ongkir dikonfirmasi admin</li>
                <li><x-icon nama="kalender" /> Hampers &amp; partai besar: pesan minimal H-{{ config('teratai.preorder_hari') }}</li>
            </ul>

            <div class="akordeon">
                <details open>
                    <summary>Profil Rasa &amp; Tekstur <x-icon nama="bawah" /></summary>
                    <div class="akordeon__isi">
                        @forelse ($paragraf as $t)<p>{{ $t }}</p>@empty<p><span class="tanda">[deskripsi {{ $p->nama }}]</span></p>@endforelse
                    </div>
                </details>
                <details>
                    <summary>Bahan Baku <x-icon nama="bawah" /></summary>
                    <div class="akordeon__isi">
                        @if ($p->komposisi)<p>{{ $p->komposisi }}</p>@else<p><span class="tanda">[komposisi {{ $p->nama }}]</span></p>@endif
                    </div>
                </details>
                <details>
                    <summary>Catatan Alergen &amp; Daya Simpan <x-icon nama="bawah" /></summary>
                    <div class="akordeon__isi">
                        <h3>Alergen</h3>
                        @if ($p->komposisi)
                            <ul class="alergen">
                                @foreach ($semuaAlergen as $id => $nama)
                                    @php($ada = in_array($id, $p->alergen, true))
                                    <li @class(['ada' => $ada])>{{ $ada ? 'Mengandung' : 'Tidak tercantum' }}: {{ $nama }}</li>
                                @endforeach
                            </ul>
                            <p>Dibaca otomatis dari komposisi. Kue dibuat di dapur yang juga mengolah kacang, susu, telur, dan terigu. <span class="tanda">[perlu konfirmasi]</span></p>
                        @else
                            <p>Info alergen belum tersedia. Tanyakan lewat WhatsApp sebelum memesan bila kamu punya alergi.</p>
                        @endif
                        <h3>Daya simpan</h3>
                        <p>Simpan dalam wadah tertutup rapat, jauh dari sinar matahari dan tempat lembap. <span class="tanda">[perlu konfirmasi: daya tahan {{ $p->nama }}]</span></p>
                    </div>
                </details>
            </div>

            <a class="tautan tautan--kecil" style="margin-top:12px" href="{{ link_wa(config('teratai.whatsapp'), "Halo Teratai Cookies, saya mau tanya tentang {$p->nama}.") }}" target="_blank" rel="noopener">
                Tanya tentang {{ $p->nama }} <x-icon nama="panah" />
            </a>
        </div>
    </article>

    @if ($rekomendasi->isNotEmpty())
        <section class="bagian" aria-labelledby="judul-rekomendasi">
            <div class="wadah">
                <div class="kepala-bagian">
                    <h2 id="judul-rekomendasi">{{ $p->kategori === 'kue-kering' ? 'Kue Lainnya' : 'Pilihan Lainnya' }}</h2>
                    <a class="tautan tautan--kecil" href="{{ route('produk.index', ['kategori' => $p->kategori]) }}">Lihat semua <x-icon nama="panah" /></a>
                </div>
                <x-rak label="Rekomendasi produk">
                    @foreach ($rekomendasi->take(3) as $r)
                        <x-product-card :produk="$r" />
                    @endforeach
                </x-rak>
            </div>
        </section>
    @endif
</x-layouts.app>
