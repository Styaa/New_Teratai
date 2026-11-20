@php
    // Harga reseller TIDAK ditampilkan di publik. Admin mengirim daftar harga setelah pendaftaran.
    $keuntungan = [
        ['ikon' => 'kartu', 'judul' => 'Harga khusus reseller', 'teks' => 'Daftar harga reseller dikirim langsung oleh admin setelah kamu mendaftar.'],
        ['ikon' => 'bintang', 'judul' => 'Produk yang sudah dikenal', 'teks' => 'Nastar, keju coklat, mente, dan rasa lain yang paling sering dipesan pelanggan kami.'],
        ['ikon' => 'kalender', 'judul' => 'Stok untuk musim ramai', 'teks' => 'Siapkan stok Lebaran, Natal, dan Imlek lebih awal bersama kami.'],
        ['ikon' => 'toko', 'judul' => 'Ambil di 2 outlet', 'teks' => 'Ambil pesanan di Pelita atau Hertasning, sesuai yang terdekat.'],
    ];
    $langkah = [
        'Isi formulir singkat di halaman ini.',
        'Pesan terbuka di WhatsApp. Kirim ke admin Teratai.',
        'Admin mengirim daftar harga reseller dan syarat pemesanan.',
        'Pesan stok pertamamu, lalu mulai berjualan.',
    ];
@endphp
<x-layouts.app
    hal="reseller"
    judul="Program Reseller Kue Kering Makassar"
    deskripsi="Jadi reseller kue kering Teratai Cookies Makassar. Harga khusus reseller, produk terlaris, dan pengambilan di 2 outlet. Daftar lewat WhatsApp."
>
    <x-jejak :jejak="[['nama' => 'Reseller', 'url' => route('reseller')]]" />
    <header class="wadah kepala-halaman">
        <span class="eyebrow">Program reseller</span>
        <h1>Jualan kue Teratai bersama kami</h1>
        <p class="lead">Untuk kamu yang ingin menjual kue kering rumahan dengan harga khusus reseller, baik untuk toko, kantor, maupun jualan online.</p>
    </header>

    <section class="bagian" aria-labelledby="judul-untung">
        <div class="wadah">
            <h2 id="judul-untung">Keuntungan jadi reseller</h2>
            <ul class="untung">
                @foreach ($keuntungan as $k)
                    <li><span class="untung__ikon"><x-icon :nama="$k['ikon']" /></span><strong>{{ $k['judul'] }}</strong><span>{{ $k['teks'] }}</span></li>
                @endforeach
            </ul>
            <p class="catatan"><span class="tanda">[perlu konfirmasi]</span> Syarat reseller (minimal order, sistem pembayaran) belum dicantumkan.</p>
        </div>
    </section>

    <section class="bagian bagian--cream" aria-labelledby="judul-daftar">
        <div class="wadah daftar-grid">
            <div>
                <span class="eyebrow">Cara daftar</span>
                <h2 id="judul-daftar">Empat langkah mudah</h2>
                <ol class="langkah">
                    @foreach ($langkah as $l)<li><span class="angka">{{ $loop->iteration }}</span>{{ $l }}</li>@endforeach
                </ol>
            </div>

            <div class="form-kartu">
                <h3>Formulir pendaftaran</h3>
                <form data-form-wa data-wa="{{ config('teratai.whatsapp') }}" data-pembuka="Halo Teratai Cookies, saya mau daftar jadi reseller:">
                    <div class="bidang">
                        <label for="rs-nama">Nama lengkap</label>
                        <input id="rs-nama" name="nama" class="input" required autocomplete="name">
                        <span class="galat" id="galat-rs-nama" data-galat-untuk="nama" hidden>Nama wajib diisi.</span>
                    </div>
                    <div class="bidang">
                        <label for="rs-kota">Kota / area jualan</label>
                        <input id="rs-kota" name="kota" class="input" required placeholder="Mis. Makassar, Gowa, Maros">
                        <span class="galat" id="galat-rs-kota" data-galat-untuk="kota" hidden>Isi kota atau area jualan.</span>
                    </div>
                    <fieldset class="bidang">
                        <legend>Cara berjualan</legend>
                        <div class="pilihan-kotak pilihan-kotak--baris">
                            <label><input type="checkbox" name="cara" value="Toko / kios"> Toko / kios</label>
                            <label><input type="checkbox" name="cara" value="Online"> Online</label>
                            <label><input type="checkbox" name="cara" value="Kantor / komunitas"> Kantor</label>
                            <label><input type="checkbox" name="cara" value="Titip jual"> Titip jual</label>
                        </div>
                    </fieldset>
                    <div class="bidang">
                        <label for="rs-outlet">Outlet pengambilan</label>
                        <select id="rs-outlet" name="outlet" class="input">
                            @foreach (config('teratai.outlet') as $o)<option>{{ $o['nama'] }}</option>@endforeach
                        </select>
                    </div>
                    <div class="bidang">
                        <label for="rs-catatan">Pesan <span class="bantu">(opsional)</span></label>
                        <textarea id="rs-catatan" name="catatan" class="input" placeholder="Mis. produk yang ingin dijual, perkiraan jumlah per bulan"></textarea>
                    </div>
                    <button type="submit" class="btn btn--wa btn--penuh"><x-icon nama="whatsapp" /> Kirim via WhatsApp</button>
                    <p class="bantu-form">Data hanya dikirim lewat WhatsApp ke admin Teratai, tidak disimpan di website.</p>
                </form>
            </div>
        </div>
    </section>
</x-layouts.app>
