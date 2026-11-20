@php
    $konfig = [
        'waUtama' => config('teratai.whatsapp'),
        'outlet' => array_map(fn ($o) => ['id' => $o['id'], 'nama' => $o['nama'], 'wa' => $o['whatsapp']], config('teratai.outlet')),
        'preorderHari' => config('teratai.preorder_hari'),
    ];
@endphp
<dialog class="laci" data-laci aria-labelledby="laci-judul" data-konfig="{{ json_encode($konfig) }}">
    <div class="laci__panel">
        <header class="laci__kepala">
            <h2 id="laci-judul">Keranjang Pesanan</h2>
            <button type="button" class="laci__tutup" data-tutup-laci aria-label="Tutup keranjang"><x-icon nama="tutup" /></button>
        </header>

        <div class="laci__isi">
            <div class="laci__kosong" data-laci-kosong>
                <x-icon nama="keranjang" />
                <p>Keranjangmu masih kosong.<br>Pilih kue favoritmu, lalu kirim pesanan lewat WhatsApp.</p>
                <a href="{{ route('produk.index') }}" class="btn btn--garis">Lihat Katalog</a>
            </div>

            <ul class="laci__daftar" data-laci-daftar aria-live="polite"></ul>

            <form class="laci__form" data-form-checkout novalidate hidden>
                <fieldset class="bidang">
                    <legend>Pilihan pengambilan</legend>
                    <div class="opsi">
                        @foreach (config('teratai.outlet') as $o)
                            <label><input type="radio" name="terima" value="ambil:{{ $o['id'] }}" @checked($loop->first)> Ambil di {{ $o['nama'] }}</label>
                        @endforeach
                        <label><input type="radio" name="terima" value="antar"> Diantar (kurir Gojek / Grab)</label>
                    </div>
                </fieldset>

                <div class="bidang" data-bidang-alamat hidden>
                    <label for="co-alamat">Alamat pengiriman</label>
                    <textarea id="co-alamat" name="alamat" class="input" rows="2" autocomplete="street-address" placeholder="Nama jalan, nomor rumah, patokan"></textarea>
                    <span class="bantu">Ongkos kirim dikonfirmasi admin lewat WhatsApp.</span>
                    <span class="galat" data-galat="alamat" hidden>Alamat wajib diisi untuk pesanan diantar.</span>
                </div>

                <div class="bidang">
                    <label for="co-tanggal" data-label-tanggal>Tanggal ambil</label>
                    <input id="co-tanggal" name="tanggal" type="date" class="input" required>
                    <span class="bantu">Hampers & partai besar: minimal H-{{ config('teratai.preorder_hari') }}.</span>
                    <span class="galat" data-galat="tanggal" hidden>Pilih tanggal mulai hari ini.</span>
                </div>

                <div class="bidang">
                    <label for="co-nama">Nama pemesan</label>
                    <input id="co-nama" name="nama" type="text" class="input" autocomplete="name" required>
                    <span class="galat" data-galat="nama" hidden>Nama wajib diisi.</span>
                </div>

                <div class="bidang">
                    <label for="co-catatan">Catatan <span class="bantu">(opsional)</span></label>
                    <textarea id="co-catatan" name="catatan" class="input" rows="2" placeholder="Kartu ucapan, jam ambil, pilihan rasa hampers"></textarea>
                </div>
            </form>
        </div>

        <footer class="laci__kaki" data-laci-kaki hidden>
            <div class="laci__total">
                <span>Total perkiraan</span>
                <strong class="harga" data-laci-total>Rp 0</strong>
            </div>
            <p class="laci__catatan" data-laci-catatan-harga hidden>Sebagian harga akan dikonfirmasi admin.</p>
            <button type="button" class="btn btn--penuh" data-kirim-wa>
                <x-icon nama="whatsapp" /> Kirim Pesanan ke WhatsApp
            </button>
            <p class="laci__catatan">Pesanan dikonfirmasi langsung oleh admin Teratai lewat WhatsApp, termasuk stok dan pembayaran.</p>
        </footer>
    </div>
</dialog>
