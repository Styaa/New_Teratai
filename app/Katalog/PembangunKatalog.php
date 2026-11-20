<?php

namespace App\Katalog;

use Illuminate\Support\Str;

/**
 * Mengubah baris database admin menjadi daftar Produk website.
 * Aturan ada di config/katalog.php, teks di config/konten-produk.php.
 */
final class PembangunKatalog
{
    /**
     * @param  array<string, mixed>  $aturan  config('katalog')
     * @param  array<string, array{ringkas:string, deskripsi?:string}>  $konten  config('konten-produk')
     */
    public function __construct(
        private readonly array $aturan,
        private readonly array $konten = [],
        private readonly string $fotoBase = '',
    ) {}

    /**
     * @param  list<array<string, mixed>>  $baris
     * @return list<Produk>
     */
    public function bangun(array $baris): array
    {
        usort($baris, fn ($a, $b) => $a['id'] <=> $b['id']);
        $hasil = [...$this->kueKering($baris), ...$this->lainnya($baris)];

        // Peringkat: total terjual → urutan 1..n (angka penjualan tidak dipublikasikan).
        $urut = $hasil;
        usort($urut, fn ($a, $b) => $b['terjual'] <=> $a['terjual']);
        foreach ($urut as $i => $p) {
            $peringkat[$p['slug']] = $i + 1;
        }

        return array_map(fn ($p) => new Produk(
            slug: $p['slug'],
            nama: $p['nama'],
            kategori: $p['kategori'],
            labelVarian: $p['label_varian'],
            varian: $p['varian'],
            ringkas: $p['ringkas'],
            deskripsi: $p['deskripsi'],
            komposisi: $p['komposisi'],
            alergen: $p['alergen'],
            best: $p['best'],
            tampil: $p['tampil'],
            peringkat: $peringkat[$p['slug']],
            foto: $p['foto'],
            musim: $p['musim'],
            merek: $p['merek'] ?? null,
        ), $hasil);
    }

    /** Kue kering: kelompokkan per rasa, kemasan menjadi varian. */
    private function kueKering(array $baris): array
    {
        $kemasanUrut = array_flip($this->aturan['kemasan_kue_kering']);
        $grup = [];
        foreach ($baris as $b) {
            if (! isset($kemasanUrut[$b['kemasan']]) || $this->tersembunyi($b['nama']) || ! ($b['harga'] > 0)) {
                continue;
            }
            [$rasa, $kemasan] = $this->pecahRasaKemasan($b);
            $kunci = mb_strtolower($rasa);
            $grup[$kunci] ??= ['rasa' => $rasa, 'baris' => []];
            $grup[$kunci]['baris'][] = ['b' => $b, 'kemasan' => $kemasan];
        }

        $hasil = [];
        foreach ($grup as ['rasa' => $rasa, 'baris' => $isi]) {
            usort($isi, fn ($x, $y) => $kemasanUrut[$x['kemasan']] <=> $kemasanUrut[$y['kemasan']]);
            $varian = [];
            foreach ($isi as ['b' => $b, 'kemasan' => $kemasan]) {
                $id = Str::slug($kemasan);
                if (isset($varian[$id])) {
                    continue; // duplikat rasa+kemasan: ambil id terlama
                }
                $varian[$id] = ['id' => $id, 'nama' => $kemasan, 'harga' => (int) $b['harga'], 'kue_id' => (int) $b['id']];
            }

            $semua = array_column($isi, 'b');
            $utama = collect($semua)->firstWhere('kemasan', 'Mika') ?? $semua[0];
            $deskripsiDb = $this->bersihkanHtml(collect($semua)->first(fn ($b) => $this->bersihkanHtml($b['deskripsi'] ?? null) !== '')['deskripsi'] ?? null);
            $komposisi = $this->komposisiValid($utama['komposisi'] ?? null)
                ?? collect($semua)->map(fn ($b) => $this->komposisiValid($b['komposisi'] ?? null))->filter()->first();
            $slug = Str::slug($rasa);
            [$ringkas, $deskripsi] = $this->teks($slug, $deskripsiDb);

            $hasil[] = [
                'slug' => $slug, 'nama' => $rasa, 'kategori' => 'kue-kering', 'label_varian' => 'Kemasan',
                'varian' => array_values($varian), 'ringkas' => $ringkas, 'deskripsi' => $deskripsi, 'komposisi' => $komposisi,
                'alergen' => self::deteksiAlergen("$rasa ".($komposisi ?? '')),
                'best' => in_array($rasa, $this->aturan['favorit'], true),
                'tampil' => in_array($rasa, $this->aturan['rasa_wajib_tampil'], true) || collect($semua)->contains(fn ($b) => (bool) $b['tampil']),
                'terjual' => array_sum(array_map(fn ($b) => (int) ($b['terjual'] ?? 0), $semua)),
                'foto' => $this->foto($rasa, array_merge(...array_map(fn ($b) => $b['gambar'] ?? [], $semua)), 'kue-kering'),
                'musim' => $this->musim($rasa, 'kue-kering'),
            ];
        }

        return $hasil;
    }

    /** Cake, hampers, snack: satu baris = satu produk (kecuali yang digabung, mis. Chiffon). */
    private function lainnya(array $baris): array
    {
        $hasil = [];
        $gabungan = [];
        $slugDipakai = [];
        foreach ($baris as $b) {
            $kategori = $this->aturan['kategori_lain'][$b['kemasan']] ?? null;
            if (! $kategori || $this->tersembunyi($b['nama']) || ! ($b['harga'] > 0)) {
                continue;
            }
            $namaDb = preg_replace('/\s+/', ' ', trim($b['nama']));
            $tampil = match (true) {
                $kategori === 'hampers' => $b['harga'] >= $this->aturan['hampers_harga_minimum'],
                in_array($b['kemasan'], $this->aturan['snack_selalu_tampil'], true) => true,
                default => (bool) $b['tampil'],
            };

            $g = collect($this->aturan['gabung_cake'])->first(fn ($g) => preg_match($g['pola'], $namaDb, $m));
            if ($g) {
                preg_match($g['pola'], $namaDb, $m);
                $slug = Str::slug($g['nama']);
                $v = ['id' => Str::slug($m[1]), 'nama' => Str::title($m[1]), 'harga' => (int) $b['harga'], 'kue_id' => (int) $b['id']];
                if (isset($gabungan[$slug])) {
                    $i = $gabungan[$slug];
                    $hasil[$i]['varian'][] = $v;
                    $hasil[$i]['tampil'] = $hasil[$i]['tampil'] || $tampil;
                    $hasil[$i]['terjual'] += (int) ($b['terjual'] ?? 0);

                    continue;
                }
                $komposisi = $this->komposisiValid($b['komposisi'] ?? null);
                [$ringkas, $deskripsi] = $this->teks($slug, $this->bersihkanHtml($b['deskripsi'] ?? null));
                $gabungan[$slug] = count($hasil);
                $slugDipakai[$slug] = true;
                $hasil[] = [
                    'slug' => $slug, 'nama' => $g['nama'], 'kategori' => $kategori, 'label_varian' => $g['label_varian'],
                    'varian' => [$v], 'ringkas' => $ringkas, 'deskripsi' => $deskripsi, 'komposisi' => $komposisi,
                    'alergen' => self::deteksiAlergen($g['nama'].' '.($komposisi ?? '')), 'best' => (bool) $b['best'],
                    'tampil' => $tampil, 'terjual' => (int) ($b['terjual'] ?? 0),
                    'foto' => $this->foto($g['nama'], $b['gambar'] ?? [], $kategori), 'musim' => [],
                ];

                continue;
            }

            $nama = $this->aturan['nama_tampil'][mb_strtolower($namaDb)] ?? $this->titleCase($namaDb);
            $slug = Str::slug($nama);
            if (isset($slugDipakai[$slug])) {
                $slug .= '-'.$b['id'];
            }
            $slugDipakai[$slug] = true;
            $varian = ! empty($b['varian'])
                ? array_map(fn ($v) => [
                    'id' => Str::slug($v['nama']), 'nama' => $this->titleCase($v['nama']),
                    'harga' => (int) ($v['harga'] ?? $b['harga']), 'kue_id' => (int) $b['id'],
                ], $b['varian'])
                : [['id' => 'standar', 'nama' => 'Standar', 'harga' => (int) $b['harga'], 'kue_id' => (int) $b['id']]];
            $komposisi = $this->komposisiValid($b['komposisi'] ?? null);
            [$ringkas, $deskripsi] = $this->teks($slug, $this->bersihkanHtml($b['deskripsi'] ?? null));

            $hasil[] = [
                'slug' => $slug, 'nama' => $nama, 'kategori' => $kategori,
                'label_varian' => ! empty($b['varian']) ? 'Rasa' : 'Pilihan', 'varian' => $varian,
                'ringkas' => $ringkas, 'deskripsi' => $deskripsi, 'komposisi' => $komposisi,
                'alergen' => self::deteksiAlergen("$nama ".($komposisi ?? '')), 'best' => false, 'tampil' => $tampil,
                'terjual' => (int) ($b['terjual'] ?? 0), 'foto' => $this->foto($nama, $b['gambar'] ?? [], $kategori),
                'musim' => $this->musim($nama, $kategori), 'merek' => $this->aturan['merek'][$b['kemasan']] ?? null,
            ];
        }

        return $hasil;
    }

    /** "Keju Kecil" di Toples Tabung = rasa Keju, kemasan Toples Tabung Kecil. */
    private function pecahRasaKemasan(array $b): array
    {
        $nama = preg_replace('/\s+/', ' ', trim($b['nama']));
        $kemasan = $b['kemasan'];
        if ($kemasan === 'Toples Tabung' && preg_match('/\skecil$/i', $nama)) {
            $nama = preg_replace('/\skecil$/i', '', $nama);
            $kemasan = 'Toples Tabung Kecil';
        }

        return [$this->aturan['alias_rasa'][mb_strtolower($nama)] ?? $this->titleCase($nama), $kemasan];
    }

    /** @return array{0:string, 1:string} [ringkas, deskripsi] */
    private function teks(string $slug, string $deskripsiDb): array
    {
        $k = $this->konten[$slug] ?? null;
        $deskripsi = $k['deskripsi'] ?? $deskripsiDb;
        $ringkas = $k['ringkas'] ?? Str::limit(preg_split('/(?<=\.)\s/', $deskripsi)[0] ?? '', 120, '…');

        return [$ringkas, $deskripsi];
    }

    private function foto(string $nama, array $files, string $kategori): array
    {
        $label = match ($kategori) {
            'kue-kering' => ['Close-up tekstur', 'Dalam toples', 'Tersusun di meja'],
            'hampers' => ['Hampers tampak depan', 'Isi hampers', 'Detail kemasan'],
            default => ['Tampak utuh', 'Potongan / detail', 'Penyajian'],
        };
        $n = max(3, $this->fotoBase ? count($files) : 0);
        $foto = [];
        for ($i = 0; $i < $n; $i++) {
            $l = $label[$i % 3];
            $foto[] = [
                'src' => $this->fotoBase && isset($files[$i]) ? "{$this->fotoBase}/{$files[$i]}" : null,
                'alt' => "$nama Teratai Cookies, ".mb_strtolower($l),
                'label' => $l,
            ];
        }

        return $foto;
    }

    private function musim(string $nama, string $kategori): array
    {
        $m = [];
        foreach ($this->aturan['musim_dari_nama'] as $pola => $musim) {
            if (preg_match($pola, $nama)) {
                $m[] = $musim;
            }
        }
        if ($kategori === 'kue-kering') {
            foreach ($this->aturan['rasa_musiman'] as $musim => $daftar) {
                if (in_array($nama, $daftar, true)) {
                    $m[] = $musim;
                }
            }
        }

        return array_values(array_unique($m));
    }

    private function tersembunyi(string $nama): bool
    {
        foreach ($this->aturan['sembunyikan_pola'] as $pola) {
            if (preg_match($pola, $nama)) {
                return true;
            }
        }

        return false;
    }

    private function komposisiValid(?string $k): ?string
    {
        $t = trim((string) $k);
        if ($t === '' || $t === '-' || $t === '0' || preg_match('/^(yes|snack|cake|cookies|puding|i)$/i', $t)) {
            return null;
        }

        return rtrim(preg_replace('/\s*,\s*/', ', ', $t), ', ');
    }

    public function bersihkanHtml(?string $html): string
    {
        $t = preg_replace(['/<\/(p|li|div)>/i', '/<br\s*\/?>/i'], "\n", (string) $html);
        $t = html_entity_decode(strip_tags($t), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $t = str_replace("\u{00A0}", ' ', $t);
        $t = preg_replace(['/[ \t]+/', '/\n\s*\n+/'], [' ', "\n"], $t);

        return trim($t);
    }

    private function titleCase(string $s): string
    {
        return preg_replace_callback('/(^|[\s(-])(\p{L})/u', fn ($m) => $m[1].mb_strtoupper($m[2]), mb_strtolower(preg_replace('/\s+/', ' ', trim($s))));
    }

    /** @return list<string> */
    public static function deteksiAlergen(string $teks): array
    {
        $t = mb_strtolower($teks);
        $hasil = [];
        if (preg_match('/tepung|terigu|cornflake|koko|biskuit|roti/', $t)) {
            $hasil[] = 'gluten';
        }
        if (str_contains($t, 'telur')) {
            $hasil[] = 'telur';
        }
        if (preg_match('/susu|butter|mentega|keju|wysman|cream|krim/', $t)) {
            $hasil[] = 'susu';
        }
        if (preg_match('/kacang|\bmente\b|\bmete\b|kenari|almond/', $t)) {
            $hasil[] = 'kacang';
        }

        return $hasil;
    }
}
