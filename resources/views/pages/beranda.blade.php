@php
    $waHero = link_wa(config('teratai.whatsapp'), 'Halo Teratai Cookies, saya mau pesan kue.');
    $keunggulan = [
        ['ikon' => 'rumah', 'judul' => 'Buatan rumahan', 'teks' => 'Dibuat di dapur Teratai sendiri, dalam jumlah yang terjaga.'],
        ['ikon' => 'daun', 'judul' => 'Bahan pilihan', 'teks' => 'Mentega, keju, dan selai nanas yang kami pilih sendiri.'],
        ['ikon' => 'toko', 'judul' => '2 outlet di Makassar', 'teks' => 'Ambil langsung di Pelita atau Hertasning.'],
    ];
    // [contoh] Ganti dengan testimoni asli yang sudah diizinkan pelanggan. Jangan karang ulasan.
    $testimoni = [
        ['nama' => '[contoh] Nama Pelanggan', 'teks' => '[contoh] Testimoni asli pelanggan akan ditampilkan di sini setelah dikumpulkan dan diizinkan.'],
        ['nama' => '[contoh] Nama Pelanggan', 'teks' => '[contoh] Gunakan kutipan nyata dari Instagram, WhatsApp, atau ulasan Google Maps.'],
        ['nama' => '[contoh] Nama Pelanggan', 'teks' => '[contoh] Jangan tampilkan rating atau jumlah pelanggan sebelum ada datanya.'],
    ];
@endphp
<x-layouts.app
    hal="beranda"
    judul="Teratai Cookies | Kue Kering, Nastar & Hampers Makassar"
    deskripsi="Kue kering rumahan dari Makassar: nastar, kastengel, kue keju, dan hampers Lebaran, Natal, Imlek. Pesan via WhatsApp, ambil di outlet Pelita atau Hertasning."
    :json-ld="\App\Support\Seo::bisnis()"
>
    {{-- HERO --}}
    <section class="hero">
        <div class="wadah hero__grid">
            <div class="hero__teks">
                <span class="eyebrow">Kue kering rumahan · Makassar</span>
                <h1>Renyahnya bikin ingat rumah.</h1>
                <p class="lead">{{ config('teratai.deskripsi') }}</p>
                <div class="hero__cta">
                    <a class="btn btn--wa" href="{{ $waHero }}" target="_blank" rel="noopener"><x-icon nama="whatsapp" /> Pesan via WhatsApp</a>
                    <a class="btn btn--garis" href="{{ route('produk.index') }}">Lihat Produk</a>
                </div>
            </div>
            <div class="hero__media">
                <x-foto :foto="['src' => null, 'alt' => 'Close-up nastar Teratai dengan remahan keju di atas talenan kayu', 'label' => 'Hero: close-up nastar, cahaya alami']"
                        jenis="hero" rasio="4 / 5" eager sizes="(min-width: 900px) 520px, 100vw" class="hero__foto" />
                @if ($nastar = $terlaris->firstWhere('slug', 'nastar'))
                    <div class="hero__kartu" aria-hidden="true">
                        <span class="badge badge--favorit">Favorit</span>
                        <strong>{{ $nastar->nama }}</strong>
                        <span class="harga">{{ $nastar->labelHarga() }}</span>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- KEUNGGULAN --}}
    <section class="keunggulan" aria-label="Keunggulan Teratai">
        <ul class="wadah keunggulan__daftar">
            @foreach ($keunggulan as $k)
                <li><span class="keunggulan__ikon"><x-icon :nama="$k['ikon']" /></span><div><strong>{{ $k['judul'] }}</strong><span>{{ $k['teks'] }}</span></div></li>
            @endforeach
        </ul>
    </section>

    <x-seasonal-banner />

    {{-- TERLARIS --}}
    <section class="bagian" aria-labelledby="judul-terlaris">
        <div class="wadah">
            <div class="kepala-bagian">
                <div>
                    <span class="eyebrow">Paling sering dipesan</span>
                    <h2 id="judul-terlaris">Kue Terlaris</h2>
                </div>
            </div>
            <x-rak label="Kue terlaris">
                @foreach ($terlaris as $p)
                    <x-product-card :produk="$p" :eager="$loop->index < 2" />
                @endforeach
            </x-rak>
            <a class="tautan-panah" href="{{ route('produk.index') }}">Lihat Semua Kue <x-icon nama="panah" /></a>
        </div>
    </section>

    {{-- KOLEKSI MUSIMAN --}}
    <section class="bagian bagian--cream koleksi" aria-labelledby="judul-koleksi">
        <div class="wadah">
            @foreach (config('teratai.musim_daftar') as $id => $m)
                <div data-musim-isi="{{ $id }}" @if ($id !== $musimAktif) hidden @endif>
                    <div class="kepala-bagian">
                        <div>
                            <span class="eyebrow koleksi__eyebrow">Edisi {{ $m['label'] }}</span>
                            <h2 @if ($id === $musimAktif) id="judul-koleksi" @endif>{{ $m['koleksi']['judul'] }}</h2>
                            <p>{{ $m['koleksi']['sub'] }}</p>
                        </div>
                        <a class="tautan-panah" href="{{ route('hampers') }}">Info pre-order <x-icon nama="panah" /></a>
                    </div>
                    <div class="grid-produk">
                        @foreach ($koleksi[$id] as $p)
                            <x-product-card :produk="$p" :musim="$id !== 'reguler'" />
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- HAMPERS --}}
    <section class="bagian" aria-labelledby="judul-hampers">
        <div class="wadah hampers">
            <div class="hampers__media">
                <x-foto :foto="['src' => null, 'alt' => 'Hampers Teratai berisi tiga toples kue kering dengan pita', 'label' => 'Hampers 3 toples + kartu ucapan']" jenis="hampers" rasio="5 / 4" sizes="(min-width: 900px) 560px, 100vw" />
            </div>
            <div class="hampers__teks">
                <span class="eyebrow">Hampers &amp; hantaran</span>
                <h2 id="judul-hampers">Hadiah manis, isi bisa kamu pilih</h2>
                <p class="lead">Hampers mulai Rp 210.000 untuk keluarga, relasi, dan kantor. Pilih rasa, tambahkan kartu ucapan, kami siapkan rapi.</p>
                <ul class="daftar-centang">
                    <li><x-icon nama="centang" :ukuran="20" /> Isi bisa custom sesuai rasa favorit</li>
                    <li><x-icon nama="centang" :ukuran="20" /> Kartu ucapan untuk setiap paket</li>
                    <li><x-icon nama="centang" :ukuran="20" /> Pesanan kantor &amp; partai besar, pesan minimal H-{{ config('teratai.preorder_hari') }}</li>
                </ul>
                <div class="hero__cta">
                    <a class="btn" href="{{ route('hampers') }}">Lihat Hampers</a>
                    <a class="btn btn--garis" href="{{ route('produk.index', ['kategori' => 'hampers']) }}">Semua Paket</a>
                </div>
            </div>
        </div>
    </section>

    {{-- TESTIMONI (placeholder) --}}
    <section class="bagian bagian--cream" aria-labelledby="judul-testimoni">
        <div class="wadah">
            <div class="kepala-bagian">
                <div>
                    <span class="eyebrow">Kata pelanggan</span>
                    <h2 id="judul-testimoni">Dari meja tamu mereka</h2>
                    <p><span class="tanda">[contoh]</span> Bagian ini menunggu testimoni asli. Tidak ada ulasan yang dikarang.</p>
                </div>
            </div>
            <ul class="testimoni">
                @foreach ($testimoni as $t)
                    <li class="testimoni__kartu">
                        <x-icon nama="hati" :ukuran="22" class="testimoni__ikon" />
                        <blockquote>{{ $t['teks'] }}</blockquote>
                        <span class="testimoni__nama">{{ $t['nama'] }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- OUTLET --}}
    <section class="bagian" aria-labelledby="judul-outlet">
        <div class="wadah">
            <div class="kepala-bagian">
                <div>
                    <span class="eyebrow">Kunjungi kami</span>
                    <h2 id="judul-outlet">Dua outlet di Makassar</h2>
                    <p>Ambil pesananmu langsung, atau mampir untuk mencicipi.</p>
                </div>
                <a class="tautan-panah" href="{{ route('outlet') }}">Lihat peta <x-icon nama="panah" /></a>
            </div>
            <div class="grid-outlet">
                @foreach (config('teratai.outlet') as $o)
                    <x-outlet-card :outlet="$o" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- DARI DAPUR YANG SAMA --}}
    <section class="bagian bagian--cream keluarga" aria-labelledby="judul-keluarga">
        <div class="wadah">
            <span class="eyebrow">Dari dapur yang sama</span>
            <h2 id="judul-keluarga" class="keluarga__judul">Keluarga usaha Teratai</h2>
            <ul class="keluarga__daftar">
                @foreach (config('teratai.keluarga_usaha') as $k)
                    <li>
                        <strong>{{ $k['nama'] }}</strong>
                        <span>{{ $k['deskripsi'] }}</span>
                        @if ($k['tautan'])
                            <a class="tautan-panah" href="{{ $k['tautan'] }}">Lihat menu <x-icon nama="panah" /></a>
                        @else
                            <span class="tanda">[link {{ $k['nama'] }}]</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- CTA PENUTUP --}}
    <section class="penutup">
        <div class="wadah penutup__isi">
            <h2>Sudah tahu mau pesan apa?</h2>
            <p>Pilih kue, masukkan ke pesanan, lalu kirim lewat WhatsApp. Admin kami akan membalas untuk konfirmasi.</p>
            <div class="hero__cta">
                <a class="btn btn--terang" href="{{ route('produk.index') }}">Pesan Sekarang</a>
                <a class="btn btn--garis-terang" href="{{ $waHero }}" target="_blank" rel="noopener"><x-icon nama="whatsapp" /> Tanya dulu</a>
            </div>
        </div>
    </section>
</x-layouts.app>
