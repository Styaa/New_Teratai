<footer class="footer">
    <div class="wadah footer__grid">
        <div class="footer__brand">
            <x-logo terang />
            <p>{{ config('teratai.deskripsi') }}</p>
            @if (config('teratai.instagram'))
                <a class="footer__ig" href="https://instagram.com/{{ config('teratai.instagram') }}" rel="noopener" target="_blank">
                    <x-icon nama="instagram" :ukuran="20" /> {{ '@'.config('teratai.instagram') }}
                </a>
            @else
                <p class="footer__ig"><x-icon nama="instagram" :ukuran="20" /> <span class="tanda">[Instagram]</span></p>
            @endif
        </div>

        <nav aria-label="Belanja">
            <h2>Belanja</h2>
            <ul>
                <li><a href="{{ route('produk.index', ['kategori' => 'kue-kering']) }}">Kue Kering</a></li>
                <li><a href="{{ route('produk.index', ['kategori' => 'cake']) }}">Cake &amp; Kue Basah</a></li>
                <li><a href="{{ route('hampers') }}">Hampers &amp; Musiman</a></li>
                <li><a href="{{ route('reseller') }}">Program Reseller</a></li>
            </ul>
        </nav>
        <nav aria-label="Informasi">
            <h2>Informasi</h2>
            <ul>
                <li><a href="{{ route('tentang') }}">Tentang Kami</a></li>
                <li><a href="{{ route('outlet') }}">Outlet</a></li>
                <li><a href="{{ route('faq') }}">FAQ</a></li>
            </ul>
        </nav>
        <div>
            <h2>Outlet</h2>
            <ul class="footer__outlet">
                @foreach (config('teratai.outlet') as $o)
                    <li>
                        <strong>{{ $o['nama'] }}</strong>
                        <span>{{ alamat_lengkap($o) }}</span>
                        <a href="{{ link_petunjuk_arah($o) }}" target="_blank" rel="noopener">Petunjuk Arah</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="wadah footer__bawah">
        <p>© {{ date('Y') }} {{ config('teratai.nama_lengkap') }}, Makassar.</p>
        <p>Harga yang tercantum adalah harga eceran dan dapat berubah sewaktu-waktu.</p>
    </div>
</footer>
