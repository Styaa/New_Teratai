@php
    $nav = [
        ['route' => 'produk.index', 'label' => 'Produk', 'aktif' => 'produk*'],
        ['route' => 'hampers', 'label' => 'Hampers', 'aktif' => 'hampers'],
        ['route' => 'reseller', 'label' => 'Reseller', 'aktif' => 'reseller'],
        ['route' => 'outlet', 'label' => 'Outlet', 'aktif' => 'outlet'],
        ['route' => 'tentang', 'label' => 'Tentang', 'aktif' => 'tentang'],
        ['route' => 'faq', 'label' => 'FAQ', 'aktif' => 'faq'],
    ];
@endphp
<header class="header" data-header>
    <div class="wadah header__isi">
        <a href="{{ route('beranda') }}" class="header__logo" aria-label="Teratai Cookies, ke beranda"><x-logo /></a>

        <nav class="header__nav" id="menu-utama" aria-label="Menu utama" data-menu>
            <ul>
                @foreach ($nav as $n)
                    <li><a href="{{ route($n['route']) }}" @if (request()->is($n['aktif'])) aria-current="page" @endif>{{ $n['label'] }}</a></li>
                @endforeach
            </ul>
            <a href="{{ route('produk.index') }}" class="btn btn--penuh header__nav-cta">Pesan Sekarang</a>
        </nav>

        <div class="header__aksi">
            <button type="button" class="ikon-btn" data-buka-keranjang aria-label="Buka pesanan">
                <x-icon nama="keranjang" />
                <span class="ikon-btn__jumlah angka" data-jumlah-keranjang hidden>0</span>
            </button>
            <button type="button" class="ikon-btn header__menu-btn" aria-expanded="false" aria-controls="menu-utama" data-tombol-menu>
                <x-icon nama="menu" class="ikon-menu" />
                <x-icon nama="tutup" class="ikon-tutup" />
                <span class="sr-only">Menu</span>
            </button>
        </div>
    </div>
</header>
