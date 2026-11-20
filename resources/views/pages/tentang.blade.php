@php
    $proses = [
        ['judul' => 'Memilih bahan', 'teks' => 'Mentega, keju, kacang mete, dan nanas untuk selai kami pilih sendiri.', 'foto' => 'Bahan-bahan di meja dapur'],
        ['judul' => 'Membuat adonan', 'teks' => 'Adonan dibuat dan dibentuk dengan tangan, sedikit demi sedikit.', 'foto' => 'Tangan membentuk nastar'],
        ['judul' => 'Memanggang', 'teks' => 'Dipanggang sampai matang merata, lalu didinginkan sebelum dikemas.', 'foto' => 'Loyang keluar dari oven'],
        ['judul' => 'Mengemas', 'teks' => 'Disusun rapi ke dalam mika atau toples agar tetap renyah sampai di rumahmu.', 'foto' => 'Toples tersusun siap dikirim'],
    ];
@endphp
<x-layouts.app
    hal="tentang"
    judul="Tentang Teratai Cookies Makassar"
    deskripsi="Cerita dapur Teratai Cookies di Makassar: kue kering rumahan, proses pembuatan, dan keluarga usaha Mie Ayam Teratai serta Jalangkote Lasinrang."
>
    <x-jejak :jejak="[['nama' => 'Tentang Kami', 'url' => route('tentang')]]" />
    <section class="hero">
        <div class="wadah hero__grid">
            <div>
                <h1>Dari dapur <span class="aksen">rumah</span> di Makassar.</h1>
                <p class="lead">{{ config('teratai.nama_lengkap') }} adalah usaha keluarga yang membuat kue kering, cake, dan hampers untuk pelanggan di Makassar.</p>
            </div>
            <x-foto :foto="['src' => null, 'alt' => 'Suasana dapur Teratai saat membuat kue kering', 'label' => 'Suasana dapur Teratai']" jenis="dapur" rasio="4 / 3" eager sizes="(min-width: 900px) 560px, 100vw" />
        </div>
    </section>

    <section class="bagian" aria-labelledby="judul-cerita">
        <div class="wadah">
            <div class="kepala-bagian"><h2 id="judul-cerita">Cerita Kami</h2></div>
            <div class="prosa">
                <p><span class="tanda">[cerita singkat pendiri]</span> Ceritakan bagaimana Teratai dimulai, siapa yang memulainya, dan resep apa yang pertama kali dibuat.</p>
                <p>
                    @if (config('teratai.tahun_berdiri'))
                        Berdiri sejak {{ config('teratai.tahun_berdiri') }}.
                    @else
                        <span class="tanda">[tahun berdiri]</span> Tahun berdiri akan ditampilkan setelah dikonfirmasi.
                    @endif
                </p>
                <p>Hari ini kami melayani pelanggan dari dua outlet, Pelita dan Hertasning, dan menyiapkan kue untuk Lebaran, Natal, Imlek, serta hantaran kantor sepanjang tahun.</p>
            </div>
        </div>
    </section>

    <section class="bagian" aria-labelledby="judul-proses">
        <div class="wadah">
            <div class="kepala-bagian"><h2 id="judul-proses">Proses Pembuatan</h2></div>
            <ol class="proses">
                @foreach ($proses as $p)
                    <li>
                        <x-foto :foto="['src' => null, 'alt' => $p['foto'], 'label' => $p['foto']]" jenis="dapur" rasio="4 / 5" sizes="(min-width: 900px) 270px, 50vw" />
                        <h3>{{ $p['judul'] }}</h3>
                        <p>{{ $p['teks'] }}</p>
                    </li>
                @endforeach
            </ol>
            <p class="catatan"><span class="tanda">[perlu konfirmasi]</span> Pastikan urutan dan klaim proses sesuai praktik di dapur.</p>
        </div>
    </section>

    <section class="bagian" aria-labelledby="judul-tim">
        <div class="wadah">
            <div class="kepala-bagian"><h2 id="judul-tim">Tim di Balik Dapur</h2></div>
            <div class="tim">
                @foreach ([1, 2, 3] as $n)
                    <figure>
                        <x-foto :foto="['src' => null, 'alt' => "Foto anggota tim Teratai $n", 'label' => "Foto tim $n"]" jenis="tim" rasio="1 / 1" sizes="(min-width: 900px) 250px, 33vw" />
                        <figcaption><span class="tanda">[nama &amp; peran]</span></figcaption>
                    </figure>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bagian" aria-labelledby="judul-keluarga">
        <div class="wadah">
            <div class="kepala-bagian"><h2 id="judul-keluarga">Dari Dapur yang Sama</h2></div>
            <ul class="keluarga">
                @foreach (config('teratai.keluarga_usaha') as $k)<li><strong>{{ $k['nama'] }}</strong>{{ $k['deskripsi'] }}</li>@endforeach
            </ul>
        </div>
    </section>
</x-layouts.app>
