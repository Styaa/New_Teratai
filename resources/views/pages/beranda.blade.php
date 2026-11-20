@php
    $musim = config("teratai.musim_daftar.$musimAktif");
    $keunggulan = [
        ['judul' => 'Buatan rumahan', 'teks' => 'Dibuat di dapur Teratai sendiri, dalam jumlah yang terjaga.'],
        ['judul' => 'Bahan pilihan', 'teks' => 'Mentega, keju, dan selai nanas yang kami pilih sendiri.'],
        ['judul' => '2 outlet di Makassar', 'teks' => 'Ambil langsung di Pelita atau Hertasning.'],
    ];
    // [contoh] Ganti dengan testimoni asli yang sudah diizinkan pelanggan. Jangan karang ulasan.
    $testimoni = [
        ['nama' => '[contoh] Nama pelanggan', 'teks' => '[contoh] Testimoni asli akan tampil di sini setelah dikumpulkan dan diizinkan.'],
        ['nama' => '[contoh] Nama pelanggan', 'teks' => '[contoh] Pakai kutipan nyata dari Instagram, WhatsApp, atau Google Maps.'],
        ['nama' => '[contoh] Nama pelanggan', 'teks' => '[contoh] Rating & jumlah pelanggan hanya ditampilkan bila datanya ada.'],
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
            <div>
                <h1>Renyahnya bikin <span class="aksen">ingat</span> rumah.</h1>
                <p class="lead">{{ config('teratai.deskripsi') }}</p>
                <div class="hero__cta">
                    <a class="btn" href="{{ route('produk.index') }}">Pesan Sekarang</a>
                    <a class="tautan" href="{{ route('produk.index') }}">Lihat produk <x-icon nama="panah" /></a>
                </div>
            </div>
            <div class="hero__media">
                <x-foto :foto="['src' => null, 'alt' => 'Nastar dan kastengel Teratai di atas piring keramik, cahaya alami', 'label' => 'Hero: nastar & kastengel di piring keramik']"
                        jenis="hero" rasio="4 / 3" eager sizes="(min-width: 900px) 560px, 100vw" />
            </div>
        </div>
    </section>

    {{-- KEUNGGULAN --}}
    <section class="bagian" aria-label="Keunggulan Teratai">
        <div class="wadah">
            <ul class="keunggulan">
                @foreach ($keunggulan as $k)
                    <li><strong>{{ $k['judul'] }}</strong>{{ $k['teks'] }}</li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- TERLARIS --}}
    <section class="bagian" aria-labelledby="judul-terlaris">
        <div class="wadah">
            <div class="kepala-bagian">
                <h2 id="judul-terlaris">Kue Terlaris</h2>
                <a class="tautan tautan--kecil" href="{{ route('produk.index') }}">Lihat semua <x-icon nama="panah" /></a>
            </div>
            <x-rak label="Kue terlaris">
                @foreach ($terlaris->take(6) as $p)
                    <x-product-card :produk="$p" :eager="$loop->index < 2" />
                @endforeach
            </x-rak>
        </div>
    </section>

    {{-- KOLEKSI MUSIMAN (berganti sesuai TERATAI_MUSIM / ?musim=) --}}
    <section class="bagian koleksi" aria-labelledby="judul-koleksi">
        <div class="wadah">
            @foreach (config('teratai.musim_daftar') as $id => $m)
                <div data-musim-isi="{{ $id }}" @if ($id !== $musimAktif) hidden @endif>
                    <div class="kepala-bagian">
                        <div>
                            <span class="label">Edisi {{ $m['label'] }}</span>
                            <h2 @if ($id === $musimAktif) id="judul-koleksi" @endif>{{ $m['koleksi']['judul'] }}</h2>
                            <p>{{ $m['koleksi']['sub'] }}</p>
                        </div>
                        <a class="tautan tautan--kecil" href="{{ route('hampers') }}">Info pre-order <x-icon nama="panah" /></a>
                    </div>
                    <x-rak label="{{ $m['koleksi']['judul'] }}">
                        @foreach ($koleksi[$id]->take(3) as $p)
                            <x-product-card :produk="$p" :musim="$id !== 'reguler'" />
                        @endforeach
                    </x-rak>
                </div>
            @endforeach
        </div>
    </section>

    {{-- HAMPERS --}}
    <section class="bagian" aria-labelledby="judul-hampers">
        <div class="wadah sorotan">
            <x-foto :foto="['src' => null, 'alt' => 'Hampers Teratai berisi toples kue kering dan kartu ucapan', 'label' => 'Hampers: kotak, toples & kartu ucapan']" jenis="hampers" rasio="16 / 10" sizes="(min-width: 900px) 600px, 100vw" />
            <div>
                <h2 id="judul-hampers">Hampers &amp; Hantaran</h2>
                <p>Paket kue kering dalam kemasan hadiah, mulai {{ rupiah(210000) }}. Isi bisa disesuaikan, ada kartu ucapan, untuk keluarga maupun kantor di Makassar dan sekitarnya.</p>
                <ul class="daftar-titik">
                    <li>Pesan minimal H-{{ config('teratai.preorder_hari') }}</li>
                    <li>Pesanan kantor &amp; partai besar</li>
                </ul>
                <a class="tautan" href="{{ route('hampers') }}">Lihat pilihan hampers <x-icon nama="panah" /></a>
            </div>
        </div>
    </section>

    {{-- TESTIMONI (placeholder) --}}
    <section class="bagian" aria-labelledby="judul-testimoni">
        <div class="wadah">
            <div class="kepala-bagian">
                <div>
                    <h2 id="judul-testimoni">Kata Pelanggan</h2>
                    <p><span class="tanda">[contoh]</span> Menunggu testimoni asli. Tidak ada ulasan yang dikarang.</p>
                </div>
            </div>
            <ul class="testimoni">
                @foreach ($testimoni as $t)
                    <li><figure style="margin:0"><blockquote>{{ $t['teks'] }}</blockquote><figcaption>{{ $t['nama'] }}</figcaption></figure></li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- OUTLET --}}
    <section class="bagian" aria-labelledby="judul-outlet">
        <div class="wadah">
            <div class="kepala-bagian">
                <h2 id="judul-outlet">Outlet Resmi</h2>
                <a class="tautan tautan--kecil" href="{{ route('outlet') }}">Lihat peta <x-icon nama="panah" /></a>
            </div>
            <div class="grid-outlet">
                @foreach (config('teratai.outlet') as $o)
                    <x-outlet-card :outlet="$o" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- DARI DAPUR YANG SAMA --}}
    <section class="bagian" aria-labelledby="judul-keluarga">
        <div class="wadah">
            <div class="kepala-bagian">
                <h2 id="judul-keluarga">Dari Dapur yang Sama</h2>
            </div>
            <ul class="keluarga">
                @foreach (config('teratai.keluarga_usaha') as $k)
                    <li>
                        <strong>{{ $k['nama'] }}</strong>
                        {{ $k['deskripsi'] }}
                        @if ($k['tautan'])
                            <a class="tautan tautan--kecil" href="{{ $k['tautan'] }}">Lihat menu <x-icon nama="panah" /></a>
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
        <div class="wadah">
            <h2>Sudah tahu mau pesan apa?</h2>
            <p>Pilih kue, masukkan ke keranjang, lalu kirim lewat WhatsApp. Admin kami akan membalas untuk konfirmasi.</p>
            <div class="hero__cta">
                <a class="btn" href="{{ route('produk.index') }}">Pesan Sekarang</a>
                <a class="tautan" href="{{ link_wa(config('teratai.whatsapp'), 'Halo Teratai Cookies, saya mau tanya tentang kue.') }}" target="_blank" rel="noopener">Tanya dulu via WhatsApp <x-icon nama="panah" /></a>
            </div>
        </div>
    </section>
</x-layouts.app>
