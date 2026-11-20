@php
    $h = config('teratai.preorder_hari');
    $minTanggal = now()->addDays($h)->toDateString();
    $langkah = [
        ['ikon' => 'hadiah', 'judul' => 'Pilih paket', 'teks' => 'Pilih hampers di bawah, atau ceritakan isi yang kamu mau.'],
        ['ikon' => 'kartu', 'judul' => 'Tulis ucapan', 'teks' => 'Sertakan pesan kartu ucapan untuk setiap paket.'],
        ['ikon' => 'kalender', 'judul' => "Pesan H-$h", 'teks' => "Minimal $h hari sebelum tanggal ambil atau kirim."],
        ['ikon' => 'truk', 'judul' => 'Ambil atau diantar', 'teks' => 'Ambil di outlet, atau kami antar di area Makassar.'],
    ];
@endphp
<x-layouts.app
    hal="hampers"
    judul="Hampers Makassar & Pesanan Musiman"
    deskripsi="Hampers kue kering Makassar untuk Lebaran, Natal, Imlek, dan hantaran kantor. Isi bisa custom, ada kartu ucapan, pesan minimal H-3 via WhatsApp."
>
    <x-jejak :jejak="[['nama' => 'Hampers & Musiman', 'url' => route('hampers')]]" />
    <header class="wadah kepala-halaman kepala-hampers">
        <div>
            <span class="eyebrow">Hampers &amp; pesanan musiman</span>
            <h1>Hampers untuk setiap momen</h1>
            <p class="lead">Kue kering pilihan dalam kemasan hadiah, untuk keluarga, relasi, dan kantor. Isi bisa disesuaikan dan setiap paket bisa dilengkapi kartu ucapan.</p>
            <div class="aksi">
                <a class="btn" href="#paket">Lihat Paket</a>
                <a class="btn btn--garis" href="#partai-besar">Pesanan Kantor</a>
            </div>
        </div>
        <x-foto :foto="['src' => null, 'alt' => 'Beberapa hampers Teratai tersusun dengan pita dan kartu ucapan', 'label' => 'Hampers tersusun + kartu ucapan']"
                jenis="hampers" rasio="4 / 3" eager sizes="(min-width: 900px) 520px, 100vw" class="kepala-hampers__foto" />
    </header>

    <section class="bagian" aria-labelledby="judul-langkah">
        <div class="wadah">
            <h2 id="judul-langkah" class="sr-only">Cara pesan hampers</h2>
            <ol class="langkah">
                @foreach ($langkah as $l)
                    <li><span class="langkah__ikon"><x-icon :nama="$l['ikon']" /></span><span class="langkah__no angka">0{{ $loop->iteration }}</span><strong>{{ $l['judul'] }}</strong><span>{{ $l['teks'] }}</span></li>
                @endforeach
            </ol>
        </div>
    </section>

    <section id="paket" class="bagian bagian--cream" aria-labelledby="judul-paket">
        <div class="wadah">
            @foreach ($perMusim as $g)
                <div class="grup-paket" data-musim="{{ $g['id'] }}">
                    <div class="kepala-bagian">
                        <div>
                            <span class="eyebrow grup-paket__eyebrow">Edisi {{ $g['label'] }}</span>
                            <h2 @if ($loop->first) id="judul-paket" @endif>Hampers {{ $g['label'] }}</h2>
                        </div>
                    </div>
                    <div class="grid-produk">
                        @foreach ($g['produk'] as $p)<x-product-card :produk="$p" musim />@endforeach
                    </div>
                </div>
            @endforeach
            <div class="grup-paket">
                <div class="kepala-bagian">
                    <div>
                        <span class="eyebrow">Sepanjang tahun</span>
                        <h2 @if ($perMusim->isEmpty()) id="judul-paket" @endif>Hampers Reguler</h2>
                        <p>Untuk ulang tahun, terima kasih, atau hantaran kapan saja.</p>
                    </div>
                </div>
                <div class="grid-produk">
                    @foreach ($reguler as $p)<x-product-card :produk="$p" />@endforeach
                </div>
            </div>
            <p class="catatan"><x-icon nama="info" :ukuran="18" /> Ketersediaan paket musiman mengikuti periode hari raya. <span class="tanda">[perlu konfirmasi: paket yang masih dijual]</span></p>
        </div>
    </section>

    <section class="bagian" aria-labelledby="judul-info">
        <div class="wadah info-grid">
            <div>
                <span class="eyebrow">Sebelum memesan</span>
                <h2 id="judul-info">Info pre-order</h2>
                <ul class="info-daftar">
                    <li><strong>Pesan minimal H-{{ $h }}.</strong> Saat Lebaran, Natal, dan Imlek kuota bisa cepat penuh, jadi lebih awal lebih aman.</li>
                    <li><strong>Kartu ucapan</strong> bisa ditulis untuk setiap paket. Kirim isi pesannya saat memesan. <span class="tanda">[perlu konfirmasi: gratis / berbayar]</span></li>
                    <li><strong>Isi custom.</strong> Ganti rasa di dalam hampers sesuai stok yang tersedia.</li>
                    <li><strong>Pengiriman</strong> di area Makassar, ongkos kirim dikonfirmasi admin. Luar kota: lihat <a href="{{ route('faq') }}">FAQ</a>.</li>
                    <li><strong>Pembayaran</strong> lewat QRIS, transfer, atau tunai di outlet. <span class="tanda">[perlu konfirmasi: DP untuk pre-order]</span></li>
                </ul>
            </div>

            <div id="partai-besar" class="form-kartu">
                <h2>Pesanan kantor &amp; partai besar</h2>
                <p>Isi formulir ini, lalu pesan akan terbuka di WhatsApp untuk dikirim ke admin.</p>
                <form data-form-wa data-wa="{{ config('teratai.whatsapp') }}" data-pembuka="Halo Teratai Cookies, saya mau pesan hampers / partai besar:">
                    <div class="bidang">
                        <label for="pb-nama">Nama</label>
                        <input id="pb-nama" name="nama" class="input" required autocomplete="name">
                        <span class="galat" id="galat-pb-nama" data-galat-untuk="nama" hidden>Nama wajib diisi.</span>
                    </div>
                    <div class="bidang">
                        <label for="pb-instansi">Instansi / kantor <span class="bantu">(opsional)</span></label>
                        <input id="pb-instansi" name="instansi" class="input" autocomplete="organization">
                    </div>
                    <div class="baris-2">
                        <div class="bidang">
                            <label for="pb-jumlah">Perkiraan jumlah paket</label>
                            <input id="pb-jumlah" name="jumlah" type="number" min="1" inputmode="numeric" class="input" required>
                            <span class="galat" id="galat-pb-jumlah" data-galat-untuk="jumlah" hidden>Isi jumlah paket.</span>
                        </div>
                        <div class="bidang">
                            <label for="pb-tanggal">Tanggal dibutuhkan</label>
                            <input id="pb-tanggal" name="tanggal" type="date" min="{{ $minTanggal }}" class="input" required>
                            <span class="galat" id="galat-pb-tanggal" data-galat-untuk="tanggal" hidden>Pilih tanggal minimal H-{{ $h }}.</span>
                        </div>
                    </div>
                    <div class="bidang">
                        <label for="pb-anggaran">Anggaran per paket <span class="bantu">(opsional)</span></label>
                        <input id="pb-anggaran" name="anggaran" class="input" placeholder="Mis. Rp 250.000">
                    </div>
                    <fieldset class="bidang">
                        <legend>Kartu ucapan</legend>
                        <div class="pilihan-kotak pilihan-kotak--baris">
                            <label><input type="radio" name="kartu" value="Ya" data-label="Ya, pakai kartu ucapan" checked> Ya</label>
                            <label><input type="radio" name="kartu" value="Tidak" data-label="Tidak perlu"> Tidak perlu</label>
                        </div>
                    </fieldset>
                    <div class="bidang">
                        <label for="pb-catatan">Detail pesanan <span class="bantu">(opsional)</span></label>
                        <textarea id="pb-catatan" name="catatan" class="input" placeholder="Rasa yang diinginkan, isi kartu ucapan, alamat kirim"></textarea>
                    </div>
                    <button type="submit" class="btn btn--wa btn--penuh"><x-icon nama="whatsapp" /> Kirim via WhatsApp</button>
                </form>
            </div>
        </div>
    </section>
</x-layouts.app>
