<footer class="footer">
    <div class="wadah footer__grid">
        <div class="footer__brand">
            <x-logo />
            <p>{{ config('teratai.deskripsi') }}</p>
        </div>

        <div>
            <h2>Lokasi Outlet</h2>
            <ul>
                @foreach (config('teratai.outlet') as $o)
                    <li><a href="{{ link_petunjuk_arah($o) }}" target="_blank" rel="noopener">{{ str_replace('Teratai ', '', $o['nama']) }}: {{ $o['jalan'] }}</a></li>
                @endforeach
            </ul>
        </div>

        <nav aria-label="Menu bawah">
            <h2>Menu</h2>
            <ul>
                <li><a href="{{ route('produk.index') }}">Produk</a></li>
                <li><a href="{{ route('hampers') }}">Hampers</a></li>
                <li><a href="{{ route('reseller') }}">Reseller</a></li>
                <li><a href="{{ route('faq') }}">FAQ</a></li>
            </ul>
        </nav>

        <div>
            <h2>Hubungi</h2>
            <ul>
                <li>
                    @if (config('teratai.whatsapp'))
                        <a href="{{ link_wa(config('teratai.whatsapp'), 'Halo Teratai Cookies') }}" target="_blank" rel="noopener">WhatsApp: +{{ config('teratai.whatsapp') }}</a>
                    @else
                        WhatsApp: <span class="tanda">[nomor WA]</span>
                    @endif
                </li>
                <li>
                    @if (config('teratai.instagram'))
                        <a href="https://instagram.com/{{ config('teratai.instagram') }}" target="_blank" rel="noopener">Instagram: {{ '@'.config('teratai.instagram') }}</a>
                    @else
                        Instagram: <span class="tanda">[Instagram]</span>
                    @endif
                </li>
            </ul>
        </div>
    </div>
    <div class="wadah footer__bawah">
        <p>© {{ date('Y') }} {{ config('teratai.nama_lengkap') }}. Harga eceran dapat berubah sewaktu-waktu.</p>
        <p>Makassar, Sulawesi Selatan</p>
    </div>
</footer>
