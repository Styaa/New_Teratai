<x-layouts.app hal="kosong" judul="Halaman tidak ditemukan" deskripsi="Halaman yang kamu cari tidak ada di Teratai Cookies." noindex>
    <section class="wadah halaman-kosong">
        <span class="label">404</span>
        <h1>Halaman ini tidak ditemukan</h1>
        <p class="lead">Mungkin tautannya sudah berubah. Yuk kembali melihat kue-kue kami.</p>
        <div class="hero__cta">
            <a class="btn" href="{{ route('produk.index') }}">Lihat Katalog</a>
            <a class="tautan" href="{{ route('beranda') }}">Ke beranda <x-icon nama="panah" /></a>
        </div>
    </section>
</x-layouts.app>
