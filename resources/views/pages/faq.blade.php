<x-layouts.app
    hal="faq"
    judul="FAQ: Daya Tahan, Penyimpanan, Pengiriman & Pembayaran"
    deskripsi="Pertanyaan umum tentang kue kering Teratai Cookies Makassar: daya tahan, cara simpan, pengiriman luar kota, dan pembayaran QRIS, transfer, atau tunai."
    :json-ld="\App\Support\Seo::faq(collect($grup)->flatMap(fn ($g) => $g['daftar'])->all())"
>
    <x-jejak :jejak="[['nama' => 'FAQ', 'url' => route('faq')]]" />
    <header class="wadah kepala-halaman">
        <h1>Pertanyaan Umum</h1>
        <p class="lead">Belum menemukan jawabannya? Tanyakan langsung lewat WhatsApp.</p>
    </header>

    <section class="bagian" aria-label="Daftar pertanyaan">
        <div class="wadah faq">
            @foreach ($grup as $g)
                <div class="faq__grup">
                    <h2>{{ $g['judul'] }}</h2>
                    <div class="akordeon">
                        @foreach ($g['daftar'] as $q)
                            <details>
                                <summary>{{ $q['t'] }} <x-icon nama="bawah" /></summary>
                                <div class="akordeon__isi"><p>{!! tanda($q['j']) !!}</p></div>
                            </details>
                        @endforeach
                    </div>
                </div>
            @endforeach
            <p class="catatan"><a class="btn" href="{{ link_wa(config('teratai.whatsapp'), 'Halo Teratai Cookies, saya mau bertanya.') }}" target="_blank" rel="noopener"><x-icon nama="whatsapp" /> Tanya via WhatsApp</a></p>
        </div>
    </section>
</x-layouts.app>
