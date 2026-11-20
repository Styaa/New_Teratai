@php
    // Harga reseller TIDAK ditampilkan di publik. Admin mengirim daftar harga setelah pendaftaran.
    $keuntungan = [
        ['judul' => 'Harga khusus reseller', 'teks' => 'Daftar harga reseller dikirim langsung oleh admin setelah kamu mendaftar.'],
        ['judul' => 'Produk yang sudah dikenal', 'teks' => 'Nastar, keju coklat, mente, dan rasa lain yang paling sering dipesan.'],
        ['judul' => 'Stok untuk musim ramai', 'teks' => 'Siapkan stok Lebaran, Natal, dan Imlek lebih awal bersama kami.'],
        ['judul' => 'Ambil di 2 outlet', 'teks' => 'Ambil pesanan di Pelita atau Hertasning, sesuai yang terdekat.'],
    ];
@endphp
<x-layouts.app
    hal="reseller"
    judul="Program Reseller Kue Kering Makassar"
    deskripsi="Jadi reseller kue kering Teratai Cookies Makassar. Harga khusus reseller, produk terlaris, dan pengambilan di 2 outlet. Daftar lewat WhatsApp."
>
    <x-jejak :jejak="[['nama' => 'Reseller', 'url' => route('reseller')]]" />
    <header class="wadah kepala-halaman">
        <h1>Program Reseller</h1>
        <p class="lead">Untuk kamu yang ingin menjual kue kering rumahan Teratai dengan harga khusus, baik di toko, kantor, maupun online.</p>
    </header>

    <section class="bagian" aria-labelledby="judul-untung">
        <div class="wadah">
            <div class="kepala-bagian"><h2 id="judul-untung">Keuntungan</h2></div>
            <ul class="langkah langkah--4">
                @foreach ($keuntungan as $k)<li><strong>{{ $k['judul'] }}</strong>{{ $k['teks'] }}</li>@endforeach
            </ul>
            <p class="catatan"><span class="tanda">[perlu konfirmasi]</span> Syarat reseller (minimal order, sistem pembayaran) belum dicantumkan.</p>
        </div>
    </section>

    <section class="bagian" aria-labelledby="judul-daftar">
        <div class="wadah dua-kolom">
            <div>
                <div class="kepala-bagian"><h2 id="judul-daftar">Cara Daftar</h2></div>
                <ul class="daftar-info">
                    <li><strong>1.</strong> Isi formulir singkat di halaman ini.</li>
                    <li><strong>2.</strong> Pesan terbuka di WhatsApp. Kirim ke admin Teratai.</li>
                    <li><strong>3.</strong> Admin mengirim daftar harga reseller dan syarat pemesanan.</li>
                    <li><strong>4.</strong> Pesan stok pertamamu, lalu mulai berjualan.</li>
                </ul>
            </div>

            <div class="panel-form">
                <h2>Formulir pendaftaran</h2>
                <p>Data hanya dikirim lewat WhatsApp ke admin Teratai, tidak disimpan di website.</p>
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
                        <div class="opsi opsi--baris">
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
                        <textarea id="rs-catatan" name="catatan" class="input" placeholder="Produk yang ingin dijual, perkiraan jumlah per bulan"></textarea>
                    </div>
                    <button type="submit" class="btn btn--penuh"><x-icon nama="whatsapp" /> Kirim via WhatsApp</button>
                </form>
            </div>
        </div>
    </section>
</x-layouts.app>
