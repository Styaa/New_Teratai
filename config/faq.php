<?php

/*
| Pertanyaan umum. Jawaban yang mengandung [perlu konfirmasi] wajib dicek pemilik sebelum rilis
| dan tidak dimasukkan ke schema FAQ.
*/

return [
    [
        'judul' => 'Kue & penyimpanan',
        'daftar' => [
            ['t' => 'Berapa lama kue kering bisa bertahan?', 'j' => 'Kue kering dalam toples tertutup rapat umumnya tetap renyah beberapa minggu pada suhu ruang. [perlu konfirmasi: daya tahan per jenis kue]'],
            ['t' => 'Bagaimana cara menyimpan kue agar tetap renyah?', 'j' => 'Simpan di toples tertutup rapat, jauh dari sinar matahari langsung dan tempat lembap. Tutup kembali toples setiap selesai mengambil kue. Cake dan kue basah sebaiknya disimpan di kulkas dan dihabiskan lebih cepat.'],
            ['t' => 'Apa bedanya kemasan Mika dan Toples?', 'j' => 'Mika adalah kemasan plastik praktis untuk dinikmati sendiri. Toples (tabung, lonjong, bulat, segi 8, kaca) lebih rapat dan rapi untuk sajian tamu atau hadiah. Harga setiap kemasan tercantum di halaman produk.'],
            ['t' => 'Apakah kue mengandung kacang, susu, telur, atau gluten?', 'j' => 'Sebagian besar kue kering mengandung terigu, susu atau mentega, dan telur, dan beberapa mengandung kacang. Info alergen tercantum di setiap halaman produk. Bila kamu punya alergi, tanyakan dulu lewat WhatsApp.'],
            ['t' => 'Apakah produk Teratai halal?', 'j' => '[perlu konfirmasi] Status sertifikasi halal belum dicantumkan di website.'],
        ],
    ],
    [
        'judul' => 'Pemesanan & pengiriman',
        'daftar' => [
            ['t' => 'Bagaimana cara memesan?', 'j' => 'Pilih kue dan kemasan, tambahkan ke pesanan, lalu tekan "Kirim Pesanan via WhatsApp". Pesanan terkirim sebagai pesan WhatsApp yang sudah terisi, lalu admin membalas untuk konfirmasi stok dan pembayaran.'],
            ['t' => 'Berapa hari sebelumnya saya harus memesan?', 'j' => 'Untuk kue yang tersedia di outlet, bisa diambil di hari yang sama sesuai stok. Hampers, pesanan musiman, dan partai besar dipesan minimal H-3.'],
            ['t' => 'Apakah bisa diantar?', 'j' => 'Bisa, untuk area Makassar. Ongkos kirim dikonfirmasi admin lewat WhatsApp sesuai alamat. [perlu konfirmasi: kurir yang dipakai dan area layanan]'],
            ['t' => 'Apakah bisa kirim ke luar kota?', 'j' => 'Kue kering bisa dikirim ke luar kota dengan jasa ekspedisi, dikemas aman agar tidak mudah hancur. Cake dan kue basah tidak kami sarankan untuk dikirim jauh. [perlu konfirmasi: ekspedisi dan kebijakan pengiriman luar kota]'],
        ],
    ],
    [
        'judul' => 'Pembayaran',
        'daftar' => [
            ['t' => 'Metode pembayaran apa saja yang diterima?', 'j' => 'QRIS, transfer bank, dan tunai saat mengambil di outlet. Detail rekening dikirim oleh admin melalui WhatsApp. [perlu konfirmasi: bank yang tersedia]'],
            ['t' => 'Apakah perlu DP untuk pre-order?', 'j' => '[perlu konfirmasi] Kebijakan uang muka untuk hampers dan pesanan partai besar.'],
            ['t' => 'Apakah harga di website sama dengan di outlet?', 'j' => 'Harga di website adalah harga eceran dan dapat berubah sewaktu-waktu. Admin akan mengonfirmasi total akhir sebelum pembayaran.'],
        ],
    ],
];
