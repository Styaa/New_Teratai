<x-layouts.app
    hal="outlet"
    judul="Outlet Teratai Cookies di Makassar: Pelita & Hertasning"
    deskripsi="Alamat, jam buka, dan petunjuk arah outlet Teratai Cookies Makassar: Jl. Pelita Raya No. 28 (Balla Parang) dan Jl. Aroeppala No. 6 (Hertasning)."
    :json-ld="\App\Support\Seo::bisnis()"
>
    <x-jejak :jejak="[['nama' => 'Outlet', 'url' => route('outlet')]]" />
    <header class="wadah kepala-halaman">
        <span class="eyebrow">Outlet</span>
        <h1>Mampir ke dapur kami</h1>
        <p class="lead">Dua outlet di Kecamatan Rappocini, Makassar. Ambil pesananmu di outlet terdekat, atau datang langsung untuk memilih kue.</p>
    </header>
    <section class="wadah grid-outlet" aria-label="Daftar outlet">
        @foreach (config('teratai.outlet') as $o)
            <x-outlet-card :outlet="$o" peta tingkat="h2" />
        @endforeach
    </section>
    <section class="wadah ojol" aria-label="Pesan online">
        <h2>Pesan lewat aplikasi</h2>
        <p>
            @if (config('teratai.grabfood') || config('teratai.gofood'))
                @if (config('teratai.grabfood'))<a href="{{ config('teratai.grabfood') }}" target="_blank" rel="noopener">GrabFood</a>@endif
                @if (config('teratai.grabfood') && config('teratai.gofood')) · @endif
                @if (config('teratai.gofood'))<a href="{{ config('teratai.gofood') }}" target="_blank" rel="noopener">GoFood</a>@endif
            @else
                <span class="tanda">[link GrabFood / GoFood bila ada]</span>
            @endif
        </p>
    </section>
</x-layouts.app>
