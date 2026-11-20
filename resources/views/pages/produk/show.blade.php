@php
    $namaKategori = config("katalog.kategori.{$p->kategori}");
    $semuaAlergen = ['kacang' => 'Kacang', 'susu' => 'Susu', 'telur' => 'Telur', 'gluten' => 'Gluten (terigu)'];
    $judul = $p->kategori === 'kue-kering' ? "Kue {$p->nama} Makassar" : "{$p->nama} Makassar";
    $deskripsiMeta = \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ',
        "{$p->nama} dari Teratai Cookies Makassar. {$p->ringkas} ".($p->hargaMulai() ? 'Mulai '.rupiah($p->hargaMulai()).'.' : '').' Pesan via WhatsApp, ambil di Pelita atau Hertasning.')), 157, '');
    $outletSingkat = collect(config('teratai.outlet'))->map(fn ($o) => str_replace('Teratai ', '', $o['nama']))->join(' atau ');
@endphp
<x-layouts.app hal="detail" :judul="$judul" :deskripsi="$deskripsiMeta" :json-ld="\App\Support\Seo::produk($p)" tipe-og="product">
    <x-jejak :jejak="[
        ['nama' => 'Produk', 'url' => route('produk.index')],
        ['nama' => $namaKategori, 'url' => route('produk.index', ['kategori' => $p->kategori])],
        ['nama' => $p->nama, 'url' => $p->url()],
    ]" />

    <article class="wadah detail">
        <div class="detail__galeri" data-galeri>
            <div class="detail__utama">
                @foreach ($p->foto as $i => $f)
                    <div class="detail__slide" data-slide="{{ $i }}" @if ($i > 0) hidden @endif>
                        <x-foto :foto="$f" :jenis="$i === 0 ? $p->jenisFoto() : 'kue'" rasio="1 / 1" :eager="$i === 0" sizes="(min-width: 900px) 560px, 100vw" />
                    </div>
                @endforeach
                @if ($p->best)<span class="badge badge--favorit detail__badge">Favorit</span>@endif
            </div>
            @if (count($p->foto) > 1)
                <div class="detail__thumbs" role="group" aria-label="Pilih foto">
                    @foreach ($p->foto as $i => $f)
                        <button type="button" class="detail__thumb" aria-pressed="{{ $i === 0 ? 'true' : 'false' }}" aria-label="Foto {{ $i + 1 }}: {{ $f['label'] }}" data-thumb="{{ $i }}">
                            <x-foto :foto="$f" :jenis="$i === 0 ? $p->jenisFoto() : 'kue'" rasio="1 / 1" :label="false" sizes="96px" />
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="detail__info">
            <span class="eyebrow">{{ $p->merek ?? $namaKategori }}</span>
            <h1>{{ $p->nama }}</h1>
            <p class="detail__ringkas">{{ $p->ringkas }}</p>

            <x-variant-picker :produk="$p" />

            <ul class="detail__jaminan">
                <li><x-icon nama="toko" :ukuran="20" /> Ambil di {{ $outletSingkat }}</li>
                <li><x-icon nama="truk" :ukuran="20" /> Bisa diantar, ongkir dikonfirmasi admin</li>
                <li><x-icon nama="kalender" :ukuran="20" /> Hampers &amp; partai besar: pesan minimal H-{{ config('teratai.preorder_hari') }}</li>
            </ul>

            <div class="detail__seksi">
                <h2>Deskripsi</h2>
                @forelse (array_filter(explode("\n", $p->deskripsi)) as $paragraf)
                    <p>{{ $paragraf }}</p>
                @empty
                    <p><span class="tanda">[deskripsi {{ $p->nama }}]</span></p>
                @endforelse
            </div>

            <div class="detail__seksi">
                <h2>Komposisi</h2>
                @if ($p->komposisi)<p>{{ $p->komposisi }}</p>@else<p><span class="tanda">[komposisi {{ $p->nama }}]</span></p>@endif
            </div>

            <div class="detail__seksi">
                <h2>Info alergen</h2>
                @if ($p->komposisi)
                    <ul class="alergen">
                        @foreach ($semuaAlergen as $id => $nama)
                            @php($ada = in_array($id, $p->alergen, true))
                            <li @class(['alergen__item', 'alergen__item--ada' => $ada])>
                                <x-icon :nama="$ada ? 'info' : 'centang'" :ukuran="16" />{{ $ada ? 'Mengandung' : 'Tidak tercantum' }}: {{ $nama }}
                            </li>
                        @endforeach
                    </ul>
                    <p class="detail__kecil">Dibaca otomatis dari komposisi. Kue dibuat di dapur yang juga mengolah kacang, susu, telur, dan terigu. <span class="tanda">[perlu konfirmasi]</span></p>
                @else
                    <p class="detail__kecil">Info alergen untuk produk ini belum tersedia. Tanyakan lewat WhatsApp sebelum memesan bila kamu punya alergi.</p>
                @endif
            </div>

            <a class="tautan-panah" href="{{ link_wa(config('teratai.whatsapp'), "Halo Teratai Cookies, saya mau tanya tentang {$p->nama}.") }}" target="_blank" rel="noopener">
                <x-icon nama="whatsapp" :ukuran="18" /> Tanya tentang {{ $p->nama }}
            </a>
        </div>
    </article>

    @if ($rekomendasi->isNotEmpty())
        <section class="bagian bagian--cream" aria-labelledby="judul-rekomendasi">
            <div class="wadah">
                <div class="kepala-bagian">
                    <div>
                        <span class="eyebrow">Sekalian dicoba</span>
                        <h2 id="judul-rekomendasi">{{ $p->kategori === 'kue-kering' ? 'Rasa lain yang sering dipesan' : 'Pilihan lainnya' }}</h2>
                    </div>
                </div>
                <x-rak label="Rekomendasi produk">
                    @foreach ($rekomendasi as $r)
                        <x-product-card :produk="$r" />
                    @endforeach
                </x-rak>
            </div>
        </section>
    @endif
</x-layouts.app>
