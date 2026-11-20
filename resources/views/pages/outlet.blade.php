<x-layouts.app
    hal="outlet"
    judul="Outlet Teratai Cookies di Makassar: Pelita & Hertasning"
    deskripsi="Alamat, jam buka, dan petunjuk arah outlet Teratai Cookies Makassar: Jl. Pelita Raya No. 28 (Balla Parang) dan Jl. Aroeppala No. 6 (Hertasning)."
    :json-ld="\App\Support\Seo::bisnis()"
>
    <x-jejak :jejak="[['nama' => 'Outlet', 'url' => route('outlet')]]" />
    <header class="wadah kepala-halaman">
        <h1>Outlet Resmi</h1>
        <p class="lead">Dua outlet di Kecamatan Rappocini, Makassar. Ambil pesananmu di outlet terdekat, atau datang langsung untuk memilih kue.</p>
    </header>
    <section class="bagian" aria-label="Daftar outlet">
        <div class="wadah grid-outlet">
            @foreach (config('teratai.outlet') as $o)
                <x-outlet-card :outlet="$o" peta tingkat="h2" />
            @endforeach
        </div>
    </section>
    <section class="bagian" aria-labelledby="judul-ojol">
        <div class="wadah">
            <div class="kepala-bagian"><h2 id="judul-ojol">Pesan lewat Aplikasi</h2></div>
            <p class="teks-2">
                @if (config('teratai.grabfood') || config('teratai.gofood'))
                    @if (config('teratai.grabfood'))<a class="tautan" href="{{ config('teratai.grabfood') }}" target="_blank" rel="noopener">GrabFood <x-icon nama="panah" /></a>@endif
                    @if (config('teratai.gofood'))<a class="tautan" href="{{ config('teratai.gofood') }}" target="_blank" rel="noopener">GoFood <x-icon nama="panah" /></a>@endif
                @else
                    <span class="tanda">[link GrabFood / GoFood bila ada]</span>
                @endif
            </p>
        </div>
    </section>
</x-layouts.app>
