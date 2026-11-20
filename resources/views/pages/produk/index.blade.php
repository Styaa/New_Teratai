<x-layouts.app
    hal="produk"
    judul="Katalog Kue Kering, Cake & Hampers"
    deskripsi="Daftar lengkap kue kering Makassar dari Teratai: nastar, kastengel, kue keju, mente, belinjo, cake, dan hampers. Lihat harga per kemasan dan pesan via WhatsApp."
>
    <x-jejak :jejak="[['nama' => 'Produk', 'url' => route('produk.index')]]" />
    <header class="wadah kepala-halaman">
        <h1>Semua Kue</h1>
        <p class="lead">Kue kering dalam berbagai kemasan, cake, dan hampers. Pilih rasa, lalu tentukan kemasan di halaman produk.</p>
    </header>

    <div class="saring" data-saring>
        <div class="wadah saring__isi">
            <div class="saring__cari">
                <x-icon nama="cari" :ukuran="20" />
                <label for="cari-produk" class="sr-only">Cari kue</label>
                <input id="cari-produk" type="search" class="input" placeholder="Cari nastar, keju, hampers…" autocomplete="off" data-cari>
            </div>
            <div class="saring__baris">
                <div class="saring__kategori" role="group" aria-label="Filter kategori">
                    <button type="button" class="chip" aria-pressed="true" data-kategori="">Semua <span class="angka">{{ $produk->count() }}</span></button>
                    @foreach ($jumlah as $id => $n)
                        <button type="button" class="chip" aria-pressed="false" data-kategori="{{ $id }}">{{ config("katalog.kategori.$id") }} <span class="angka">{{ $n }}</span></button>
                    @endforeach
                </div>
                <div class="saring__urut">
                    <label for="urut-produk">Urutkan</label>
                    <select id="urut-produk" class="input" data-urut>
                        <option value="terlaris">Terlaris</option>
                        <option value="harga-naik">Harga terendah</option>
                        <option value="harga-turun">Harga tertinggi</option>
                        <option value="nama">Nama A–Z</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <section class="wadah katalog" aria-label="Daftar produk">
        <p class="katalog__info" role="status" data-info>{{ $produk->count() }} produk</p>
        <div class="grid-produk" data-grid>
            @foreach ($produk as $p)
                <x-product-card :produk="$p" :eager="$loop->index < 4" tingkat="h2" />
            @endforeach
        </div>
        <div class="katalog__kosong" data-kosong hidden>
            <p><strong>Belum ketemu kue yang kamu cari.</strong></p>
            <p>Coba kata lain, atau tanyakan langsung lewat WhatsApp. Kami juga menerima pesanan khusus.</p>
            <button type="button" class="btn btn--garis" data-reset>Tampilkan semua</button>
        </div>
    </section>
</x-layouts.app>
