<?php

/*
|--------------------------------------------------------------------------
| Data toko Teratai Cookies
|--------------------------------------------------------------------------
| Semua yang bertanda TODO / [perlu konfirmasi] wajib diisi sebelum rilis.
| Daftar lengkap: PLACEHOLDER.md
*/

return [

    'nama' => 'Teratai Cookies',
    'nama_lengkap' => 'Jo&S Teratai Cookies & Cake',
    'url' => env('APP_URL', 'https://terataicookies.com'),
    'kota' => 'Makassar',
    'deskripsi' => 'Kue kering rumahan dari dapur Teratai, Makassar, dibuat dengan bahan pilihan untuk setiap momen berharga.',

    // Nomor WhatsApp pemesanan utama, format 62xxxxxxxxxx. TODO: isi.
    // Selama kosong, tombol WhatsApp membuka WhatsApp dengan pesan terisi dan pelanggan memilih kontak sendiri.
    'whatsapp' => env('TERATAI_WHATSAPP', ''),

    'instagram' => env('TERATAI_INSTAGRAM', ''),   // TODO: username tanpa @
    'grabfood' => '',                               // TODO: link bila ada
    'gofood' => '',                                 // TODO: link bila ada
    'tahun_berdiri' => '',                          // TODO [perlu konfirmasi]

    // Minimal hari pemesanan untuk pre-order hampers / partai besar.
    'preorder_hari' => 3,

    // Mode musiman: reguler | lebaran | natal | imlek
    'musim' => env('TERATAI_MUSIM', 'natal'),

    'outlet' => [
        [
            'id' => 'pelita',
            'nama' => 'Teratai Pelita',
            'jalan' => 'Jl. Pelita Raya No. 28',
            'kelurahan' => 'Balla Parang',
            'kecamatan' => 'Rappocini',
            'kota' => 'Makassar',
            'provinsi' => 'Sulawesi Selatan',
            'kode_pos' => '90231',
            'whatsapp' => '',   // TODO: nomor WA outlet (62xxx)
            // TODO: jam buka, contoh:
            // ['hari' => 'Senin–Sabtu', 'buka' => '08:00', 'tutup' => '21:00',
            //  'schema_hari' => ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday']],
            'jam' => [],
            'geo' => null,      // TODO [perlu konfirmasi]: ['lat' => -5.xxx, 'lng' => 119.xxx]
        ],
        [
            'id' => 'hertasning',
            'nama' => 'Teratai Hertasning',
            'jalan' => 'Jl. Aroeppala No. 6',
            'kelurahan' => 'Karunrung',
            'kecamatan' => 'Rappocini',
            'kota' => 'Makassar',
            'provinsi' => 'Sulawesi Selatan',
            'kode_pos' => '90221',
            'whatsapp' => '',
            'jam' => [],
            'geo' => null,
        ],
    ],

    'keluarga_usaha' => [
        [
            'nama' => 'Mie Ayam Teratai',
            'deskripsi' => 'Mie ayam dengan pangsit dan bakso, dari dapur yang sama.',
            'tautan' => '', // TODO: link Instagram / GrabFood bila ada
        ],
        [
            'nama' => 'Jalangkote Lasinrang',
            'deskripsi' => 'Jalangkote dan lumpia khas Makassar, tersedia juga versi frozen.',
            'tautan' => '/produk?kategori=snack',
        ],
    ],

    /*
    | Katalog
    | sumber: 'db'   = baca langsung dari database admin (koneksi 'admin' di config/database.php)
    |         'json' = database/data/katalog-db.json (hasil database/data/export-katalog.sql)
    */
    'katalog' => [
        'sumber' => env('KATALOG_SUMBER', 'json'),
        'cache_detik' => (int) env('KATALOG_CACHE_DETIK', 600),
        // Alamat folder foto produk di server admin. File: {foto_base}/{id}.{ext} (tabel `gambar`).
        'foto_base' => rtrim((string) env('KATALOG_FOTO_BASE', ''), '/'),
    ],

    'musim_daftar' => [
        'reguler' => [
            'label' => 'Reguler',
            'banner' => [
                'eyebrow' => 'Hantaran & hampers',
                'judul' => 'Hadiah manis untuk orang terdekat',
                'sub' => 'Hampers kue kering untuk kantor, keluarga, dan acara. Isi bisa disesuaikan.',
                'cta' => 'Lihat Hampers',
            ],
            'koleksi' => ['judul' => 'Pilihan untuk Hantaran', 'sub' => 'Kue dan hampers yang paling sering dipilih untuk hadiah.'],
        ],
        'lebaran' => [
            'label' => 'Lebaran',
            'banner' => [
                'eyebrow' => 'Koleksi Lebaran',
                'judul' => 'Toples Lebaran sudah bisa dipesan',
                'sub' => 'Nastar, kastengel, dan kue bangkit untuk meja tamu. Pesan lebih awal agar tanggal ambilmu aman.',
                'cta' => 'Pesan Kue Lebaran',
            ],
            'koleksi' => ['judul' => 'Koleksi Lebaran', 'sub' => 'Kue yang selalu ada di meja tamu saat hari raya.'],
        ],
        'natal' => [
            'label' => 'Natal',
            'banner' => [
                'eyebrow' => 'Koleksi Natal',
                'judul' => 'Kue dan hampers Natal sudah dibuka',
                'sub' => 'Nastar, tosca khas Manado, dan hampers Natal. Pesan minimal H-3 agar tanggal ambilmu aman.',
                'cta' => 'Lihat Koleksi Natal',
            ],
            'koleksi' => ['judul' => 'Koleksi Natal', 'sub' => 'Kue kering dan hampers untuk merayakan Natal bersama keluarga.'],
        ],
        'imlek' => [
            'label' => 'Imlek',
            'banner' => [
                'eyebrow' => 'Koleksi Imlek',
                'judul' => 'Hampers Imlek untuk keluarga dan relasi',
                'sub' => 'Nastar dan kue kering pilihan dalam kemasan Imlek. Pesan minimal H-3.',
                'cta' => 'Lihat Hampers Imlek',
            ],
            'koleksi' => ['judul' => 'Koleksi Imlek', 'sub' => 'Nastar, kastengel, dan hampers untuk Tahun Baru Imlek.'],
        ],
    ],
];
