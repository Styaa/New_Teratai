<x-layouts.app
    hal="produk"
    judul="Katalog Kue Kering, Cake & Hampers"
    deskripsi="Daftar lengkap kue kering Makassar dari Teratai: nastar, kastengel, kue keju, mente, belinjo, cake, dan hampers. Lihat harga per kemasan dan pesan via WhatsApp."
>
    <x-jejak :jejak="[['nama' => 'Produk', 'url' => route('produk.index')]]" />
    <section class="wadah katalog" aria-labelledby="judul-katalog">
        <header class="kepala-halaman" style="padding-bottom:0">
            <h1 id="judul-katalog">Katalog Produk</h1>
            <p class="lead">Kue kering rumahan dalam berbagai kemasan, cake, dan hampers dari dapur Teratai, Makassar.</p>
        </header>

        <div class="toolbar">
            <div class="tab-kategori" role="group" aria-label="Filter kategori">
                <button type="button" class="tab" aria-pressed="true" data-kategori="">Semua <span class="angka">{{ $produk->count() }}</span></button>
                @foreach ($jumlah as $id => $n)
                    <button type="button" class="tab" aria-pressed="false" data-kategori="{{ $id }}">{{ config("katalog.kategori.$id") }} <span class="angka">{{ $n }}</span></button>
                @endforeach
            </div>
            <div class="toolbar__alat">
                <div class="cari">
                    <x-icon nama="cari" />
                    <label for="cari-produk" class="sr-only">Cari kue</label>
                    <input id="cari-produk" type="search" placeholder="Cari rasa kue…" autocomplete="off" data-cari>
                </div>
                <div class="urut">
                    <label for="urut-produk" class="sr-only">Urutkan</label>
                    <select id="urut-produk" data-urut>
                        <option value="terlaris">Terpopuler</option>
                        <option value="harga-naik">Harga terendah</option>
                        <option value="harga-turun">Harga tertinggi</option>
                        <option value="nama">Nama A–Z</option>
                    </select>
                    <x-icon nama="bawah" />
                </div>
            </div>
        </div>

        <p class="katalog__info" role="status" data-info>{{ $produk->count() }} produk</p>
        <div class="grid-produk" data-grid>
            @foreach ($produk as $p)
                <x-product-card :produk="$p" :eager="$loop->index < 3" tingkat="h2" />
            @endforeach
        </div>
        <div class="katalog__kosong" data-kosong hidden>
            <p><strong>Belum ketemu kue yang kamu cari.</strong></p>
            <p>Coba kata lain, atau tanyakan langsung lewat WhatsApp. Kami juga menerima pesanan khusus.</p>
            <button type="button" class="btn btn--garis" data-reset>Tampilkan semua</button>
        </div>
    </section>
</x-layouts.app>
