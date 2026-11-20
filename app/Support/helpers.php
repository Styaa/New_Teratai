<?php

/** Helper global untuk view. Didaftarkan lewat composer.json "autoload.files". */
if (! function_exists('rupiah')) {
    function rupiah(int|float $n): string
    {
        return 'Rp '.number_format((float) $n, 0, ',', '.');
    }
}

if (! function_exists('link_wa')) {
    /** Nomor kosong = WhatsApp membuka pemilih kontak dengan pesan terisi. */
    function link_wa(?string $nomor, string $teks): string
    {
        return 'https://wa.me/'.preg_replace('/\D/', '', (string) $nomor).'?text='.rawurlencode($teks);
    }
}

if (! function_exists('alamat_lengkap')) {
    function alamat_lengkap(array $o): string
    {
        return "{$o['jalan']}, {$o['kelurahan']}, Kec. {$o['kecamatan']}, {$o['kota']}, {$o['provinsi']} {$o['kode_pos']}";
    }
}

if (! function_exists('link_petunjuk_arah')) {
    function link_petunjuk_arah(array $o): string
    {
        $tujuan = $o['geo'] ? "{$o['geo']['lat']},{$o['geo']['lng']}" : rawurlencode("Teratai Cookies {$o['jalan']}, {$o['kelurahan']}, {$o['kota']}");

        return "https://www.google.com/maps/dir/?api=1&destination={$tujuan}";
    }
}

if (! function_exists('link_embed_peta')) {
    function link_embed_peta(array $o): string
    {
        $q = $o['geo'] ? "{$o['geo']['lat']},{$o['geo']['lng']}" : rawurlencode("Teratai Cookies {$o['jalan']}, {$o['kelurahan']}, {$o['kota']}");

        return "https://www.google.com/maps?q={$q}&z=16&output=embed";
    }
}

if (! function_exists('tanda')) {
    /** Mengubah "[perlu konfirmasi …]" / "[contoh]" di teks menjadi penanda kuning. Input di-escape dulu. */
    function tanda(string $teks): string
    {
        return preg_replace('/\[(perlu konfirmasi[^\]]*|contoh[^\]]*)\]/', '<span class="tanda">[$1]</span>', e($teks));
    }
}
