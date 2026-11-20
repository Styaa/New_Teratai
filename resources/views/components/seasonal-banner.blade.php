{{-- Banner musiman. Semua musim dirender, hanya yang aktif terlihat. Pratinjau: ?musim=lebaran --}}
<section class="banner-musim" aria-label="Info musiman">
    <div class="wadah">
        @foreach (config('teratai.musim_daftar') as $id => $m)
            <div class="banner-musim__kartu" data-musim-isi="{{ $id }}" @if ($id !== $musimAktif) hidden @endif>
                <div class="banner-musim__hias" aria-hidden="true"><span></span><span></span><span></span></div>
                <div class="banner-musim__teks">
                    <span class="banner-musim__eyebrow">{{ $m['banner']['eyebrow'] }}</span>
                    <h2>{{ $m['banner']['judul'] }}</h2>
                    <p>{{ $m['banner']['sub'] }}</p>
                </div>
                <a href="{{ route('hampers') }}" class="btn btn--terang">{{ $m['banner']['cta'] }} <x-icon nama="panah" /></a>
            </div>
        @endforeach
    </div>
</section>
