@php
    $h = config('teratai.preorder_hari');
    $langkah = [
        ['judul' => 'Pilih paket', 'teks' => 'Pilih hampers di bawah, atau ceritakan isi yang kamu mau.'],
        ['judul' => 'Tulis ucapan', 'teks' => 'Sertakan pesan kartu ucapan untuk setiap paket.'],
        ['judul' => "Pesan H-$h", 'teks' => "Minimal $h hari sebelum tanggal ambil atau kirim."],
        ['judul' => 'Ambil atau diantar', 'teks' => 'Ambil di outlet, atau kami antar di area Makassar.'],
    ];
@endphp
<x-layouts.app
    hal="hampers"
    judul="Hampers Makassar & Pesanan Musiman"
    deskripsi="Hampers kue kering Makassar untuk Lebaran, Natal, Imlek, dan hantaran kantor. Isi bisa custom, ada kartu ucapan, pesan minimal H-3 via WhatsApp."
>
    <x-jejak :jejak="[['nama' => 'Hampers & Musiman', 'url' => route('hampers')]]" />
    <section class="hero">
        <div class="wadah hero__grid">
            <div>
                <h1>Hampers untuk setiap <span class="aksen">momen</span>.</h1>
                <p class="lead">Kue kering pilihan dalam kemasan hadiah, untuk keluarga, relasi, dan kantor. Isi bisa disesuaikan dan setiap paket bisa dilengkapi kartu ucapan.</p>
                <div class="hero__cta">
                    <a class="btn" href="#paket">Lihat Paket</a>
                    <a class="tautan" href="#partai-besar">Pesanan kantor <x-icon nama="panah" /></a>
                </div>
            </div>
            <x-foto :foto="['src' => null, 'alt' => 'Beberapa hampers Teratai tersusun dengan pita dan kartu ucapan', 'label' => 'Hampers tersusun + kartu ucapan']"
                    jenis="hampers" rasio="4 / 3" eager sizes="(min-width: 900px) 560px, 100vw" />
        </div>
    </section>

    <section class="bagian" aria-labelledby="judul-langkah">
        <div class="wadah">
            <div class="kepala-bagian"><h2 id="judul-langkah">Cara Pesan</h2></div>
            <ol class="langkah langkah--4">
                @foreach ($langkah as $l)<li><strong>{{ $l['judul'] }}</strong>{{ $l['teks'] }}</li>@endforeach
            </ol>
        </div>
    </section>

    <section id="paket" class="bagian" aria-label="Paket hampers">
        <div class="wadah">
            @foreach ($perMusim as $g)
                <div class="grup-paket" data-musim="{{ $g['id'] }}">
                    <div class="kepala-bagian">
                        <div>
                            <span class="label">Edisi {{ $g['label'] }}</span>
                            <h2>Hampers {{ $g['label'] }}</h2>
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
                        <span class="label">Sepanjang tahun</span>
                        <h2>Hampers Reguler</h2>
                        <p>Untuk ulang tahun, terima kasih, atau hantaran kapan saja.</p>
                    </div>
                </div>
                <div class="grid-produk">
                    @foreach ($reguler as $p)<x-product-card :produk="$p" />@endforeach
                </div>
            </div>
            <p class="catatan">Ketersediaan paket musiman mengikuti periode hari raya. <span class="tanda">[perlu konfirmasi: paket yang masih dijual]</span></p>
        </div>
    </section>

    <section class="bagian" aria-labelledby="judul-info">
        <div class="wadah dua-kolom">
            <div>
                <div class="kepala-bagian"><h2 id="judul-info">Info Pre-order</h2></div>
                <ul class="daftar-info">
                    <li><strong>Pesan minimal H-{{ $h }}.</strong> Saat Lebaran, Natal, dan Imlek kuota bisa cepat penuh, jadi lebih awal lebih aman.</li>
                    <li><strong>Kartu ucapan</strong> bisa ditulis untuk setiap paket. Kirim isi pesannya saat memesan. <span class="tanda">[perlu konfirmasi: gratis / berbayar]</span></li>
                    <li><strong>Isi custom.</strong> Ganti rasa di dalam hampers sesuai stok yang tersedia.</li>
                    <li><strong>Pengiriman</strong> di area Makassar, ongkos kirim dikonfirmasi admin. Luar kota: lihat <a href="{{ route('faq') }}">FAQ</a>.</li>
                    <li><strong>Pembayaran</strong> lewat QRIS, transfer, atau tunai di outlet. <span class="tanda">[perlu konfirmasi: DP untuk pre-order]</span></li>
                </ul>
            </div>

            <div id="partai-besar" class="panel-form">
                <h2>Pesanan kantor &amp; partai besar</h2>
                <p>Isi formulir ini, lalu pesan terbuka di WhatsApp untuk dikirim ke admin.</p>
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
                            <input id="pb-tanggal" name="tanggal" type="date" min="{{ now()->addDays($h)->toDateString() }}" class="input" required>
                            <span class="galat" id="galat-pb-tanggal" data-galat-untuk="tanggal" hidden>Pilih tanggal minimal H-{{ $h }}.</span>
                        </div>
                    </div>
                    <div class="bidang">
                        <label for="pb-anggaran">Anggaran per paket <span class="bantu">(opsional)</span></label>
                        <input id="pb-anggaran" name="anggaran" class="input" placeholder="Mis. Rp 250.000">
                    </div>
                    <fieldset class="bidang">
                        <legend>Kartu ucapan</legend>
                        <div class="opsi opsi--baris">
                            <label><input type="radio" name="kartu" value="Ya" data-label="Ya, pakai kartu ucapan" checked> Ya</label>
                            <label><input type="radio" name="kartu" value="Tidak" data-label="Tidak perlu"> Tidak perlu</label>
                        </div>
                    </fieldset>
                    <div class="bidang">
                        <label for="pb-catatan">Detail pesanan <span class="bantu">(opsional)</span></label>
                        <textarea id="pb-catatan" name="catatan" class="input" placeholder="Rasa yang diinginkan, isi kartu ucapan, alamat kirim"></textarea>
                    </div>
                    <button type="submit" class="btn btn--penuh"><x-icon nama="whatsapp" /> Kirim via WhatsApp</button>
                </form>
            </div>
        </div>
    </section>
</x-layouts.app>
