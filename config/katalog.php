<?php

/*
|--------------------------------------------------------------------------
| Aturan katalog: dari baris database admin menjadi produk website
|--------------------------------------------------------------------------
| Di admin, satu baris `kue` = satu rasa dalam satu kemasan, dan tabel `kategori`
| berisi kemasan. Ubah file ini (bukan view) untuk menyembunyikan/menampilkan produk,
| menyatukan ejaan rasa, atau mengganti urutan kemasan.
*/

return [

    // Kemasan kue kering, sesuai urutan di pemilih varian. Kunci = nama di tabel `kategori`.
    'kemasan_kue_kering' => [
        'Mika', 'Toples Tabung Kecil', 'Toples Tabung Sedang', 'Toples Tabung', 'Toples Tabung Besar',
        'Toples Tabung Spesial', 'Toples Lonjong', 'Kotak Classic', 'Kotak Roombutter', 'Toples Bulat',
        'Toples Kotak', 'Toples Segi 8', 'Toples 3 Rasa', 'Toples Kaca Kecil', 'Toples Kaca Sedang', 'Toples Kaca Tinggi',
    ],

    // Jenis lain di tabel `kategori` → kategori website. Yang tidak tercantum disembunyikan.
    'kategori_lain' => [
        'Cake' => 'cake',
        'Hampers' => 'hampers',
        'Jalangkote & Lumpia' => 'snack',
        'Selai' => 'snack',
    ],

    'kategori' => [
        'kue-kering' => 'Kue Kering',
        'cake' => 'Cake & Kue Basah',
        'hampers' => 'Hampers',
        'snack' => 'Snack',
    ],

    // Menyatukan ejaan rasa yang berbeda (kunci huruf kecil). [perlu konfirmasi]
    'alias_rasa' => [
        'nastar bulat' => 'Nastar',
        'keju coklat bulat' => 'Keju Coklat',
        'speculash kenari' => 'Spekulas Kenari',
        'speculas kenari' => 'Spekulas Kenari',
        'spekulas kenari' => 'Spekulas Kenari',
        'speculas' => 'Spekulas Kenari',
        'blubery keju' => 'Blueberry Keju',
        'chip mata' => 'Coklat Chip Mata',
        'coklat chip mata' => 'Coklat Chip Mata',
        'selai' => 'Selai 3 Rasa',
        'campur 3 rasa' => 'Toples 3 Rasa',
        'coklat koko crunch' => 'Coklat Koko Krunch',
    ],

    // Rasa kue kering yang selalu tampil (dari brief), walau `tampil = 0` di admin.
    // Rasa lain tampil hanya bila minimal satu kemasannya `tampil = 1`.
    'rasa_wajib_tampil' => [
        'Nastar', 'Nastar Daun', 'Kastengel', 'Keju', 'Keju Coklat', 'Coklat Chip', 'Coklat Mente',
        'Coklat Cornflake', 'Mente', 'Mente Keju', 'Belinjo', 'Belinjo Keju', 'Kacang', 'Kacang Coklat',
        'Bangket Kacang', 'Bangket Mente', 'Salju', 'Sagu', 'Blueberry Keju', 'Stick Coklat', 'Kopi',
        'Selai 3 Rasa', 'Tosca', 'Toples 3 Rasa',
    ],

    // Badge "Favorit" (dari brief). Urutan "Terlaris" tetap dari data penjualan.
    'favorit' => [
        'Nastar', 'Keju Coklat', 'Coklat Chip', 'Mente', 'Coklat Cornflake', 'Belinjo', 'Keju', 'Kastengel', 'Nastar Daun',
    ],

    // Nama yang cocok dengan pola ini tidak pernah tampil (barang internal / bonus).
    'sembunyikan_pola' => ['/tester/i', '/^bonus\b/i', '/minyak bekas/i'],

    // Cake yang digabung menjadi satu produk dengan pilihan rasa.
    'gabung_cake' => [
        ['pola' => '/^chiffon (keju|coklat|pandan) 20 ?cm$/i', 'nama' => 'Chiffon Cake 20 cm', 'label_varian' => 'Rasa'],
    ],

    // Nama tampilan khusus (kunci = nama di database, huruf kecil).
    'nama_tampil' => [
        'brownis kukus' => 'Brownis Kukus',
        'keju gonrong 30 cm' => 'Keju Gonrong 30 cm',
        'marbel cake' => 'Marmer Cake',
        'bolu rampah' => 'Bolu Rampah',
        'otak otak' => 'Otak-otak',
        'risol mayo' => 'Risol Mayo',
        'risol mentai' => 'Risol Mentai',
        'pudding coklat' => 'Puding Coklat',
    ],

    // Snack dari kemasan ini selalu tampil (Jalangkote Lasinrang). Cake lain hanya bila `tampil = 1`.
    'snack_selalu_tampil' => ['Jalangkote & Lumpia'],
    'merek' => ['Jalangkote & Lumpia' => 'Jalangkote Lasinrang'],

    // Hampers tampil bila harga ≥ batas ini (yang lebih murah adalah kemasan/isi, bukan paket).
    'hampers_harga_minimum' => 95000,

    'musim_dari_nama' => [
        '/natal/i' => 'natal',
        '/imlek/i' => 'imlek',
        '/idul ?fit|ramadhan|lebaran/i' => 'lebaran',
    ],

    'rasa_musiman' => [
        'lebaran' => ['Nastar', 'Kastengel', 'Bangket Kacang', 'Bangket Mente', 'Salju', 'Toples 3 Rasa'],
        'natal' => ['Nastar', 'Kastengel', 'Tosca', 'Spekulas Kenari', 'Salju', 'Coklat Mente'],
        'imlek' => ['Nastar', 'Kastengel', 'Keju Coklat', 'Mente Keju', 'Kacang'],
    ],
];
