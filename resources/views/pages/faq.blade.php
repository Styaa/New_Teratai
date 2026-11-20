<x-layouts.app
    hal="faq"
    judul="FAQ: Daya Tahan, Penyimpanan, Pengiriman & Pembayaran"
    deskripsi="Pertanyaan umum tentang kue kering Teratai Cookies Makassar: daya tahan, cara simpan, pengiriman luar kota, dan pembayaran QRIS, transfer, atau tunai."
    :json-ld="\App\Support\Seo::faq(collect($grup)->flatMap(fn ($g) => $g['daftar'])->all())"
>
    <x-jejak :jejak="[['nama' => 'FAQ', 'url' => route('faq')]]" />
    <header class="wadah kepala-halaman">
        <span class="eyebrow">FAQ</span>
        <h1>Pertanyaan yang sering ditanyakan</h1>
        <p class="lead">Belum menemukan jawabannya? Tanyakan langsung lewat WhatsApp.</p>
    </header>

    <div class="wadah faq">
        @foreach ($grup as $g)
            <section aria-label="{{ $g['judul'] }}" class="faq__grup">
                <h2>{{ $g['judul'] }}</h2>
                @foreach ($g['daftar'] as $q)
                    <details class="faq__item">
                        <summary>{{ $q['t'] }}<x-icon nama="bawah" :ukuran="20" /></summary>
                        <p>{!! tanda($q['j']) !!}</p>
                    </details>
                @endforeach
            </section>
        @endforeach
        <a class="btn btn--wa" href="{{ link_wa(config('teratai.whatsapp'), 'Halo Teratai Cookies, saya mau bertanya.') }}" target="_blank" rel="noopener"><x-icon nama="whatsapp" /> Tanya via WhatsApp</a>
    </div>
</x-layouts.app>
