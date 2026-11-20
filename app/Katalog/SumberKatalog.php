<?php

namespace App\Katalog;

/**
 * Sumber baris katalog. Bentuk setiap baris:
 * ['id'=>int, 'nama'=>string, 'kemasan'=>string, 'harga'=>float, 'deskripsi'=>?string, 'komposisi'=>?string,
 *  'best'=>int, 'tampil'=>int, 'gambar'=>?list<string>, 'varian'=>?list<array{nama:string,harga:?float}>, 'terjual'=>int]
 */
interface SumberKatalog
{
    /** @return list<array<string, mixed>> */
    public function baris(): array;
}
