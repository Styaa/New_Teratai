<?php

namespace App\Katalog;

use Illuminate\Database\ConnectionInterface;

/**
 * Katalog langsung dari database admin (koneksi 'admin').
 *
 * Hanya kolom yang aman untuk publik yang dipilih: TIDAK ada harga_reseller, stok, pelanggan, atau
 * transaksi per orang. Dari penjualan hanya diambil total per kue, dan yang ditampilkan di website
 * hanya urutannya, bukan angkanya.
 * Sebaiknya koneksi 'admin' memakai user MySQL read-only (lihat README).
 */
final class SumberDatabase implements SumberKatalog
{
    public function __construct(private readonly ConnectionInterface $db) {}

    public function baris(): array
    {
        $kue = $this->db->table('kue as k')
            ->join('kategori as kt', 'kt.id', '=', 'k.kategori_id')
            ->whereNull('k.deleted_at')
            ->where('k.harga', '>', 0)
            ->whereNotIn('kt.nama', ['Minuman', 'Hiasan', 'Toping', 'Mie Ayam'])
            ->orderBy('k.id')
            ->get(['k.id', 'k.nama', 'kt.nama as kemasan', 'k.harga', 'k.deskripsi', 'k.komposisi', 'k.best', 'k.tampil']);

        $ids = $kue->pluck('id')->all();
        if (! $ids) {
            return [];
        }

        $gambar = $this->db->table('gambar')->whereIn('kue_id', $ids)->orderBy('id')
            ->get(['id', 'ext', 'kue_id'])->groupBy('kue_id');

        $varian = $this->db->table('kue_varian')->whereIn('kue_id', $ids)->orderBy('id')
            ->get(['kue_id', 'nama_varian', 'harga'])->groupBy('kue_id');

        $terjual = [];
        foreach (['nota_has_kue', 't_notas_has_kue'] as $tabel) {
            $this->db->table($tabel)->whereIn('kue_id', $ids)->groupBy('kue_id')
                ->selectRaw('kue_id, SUM(jumlah) as total')->get()
                ->each(function ($r) use (&$terjual) {
                    $terjual[$r->kue_id] = ($terjual[$r->kue_id] ?? 0) + (int) $r->total;
                });
        }

        return $kue->map(fn ($k) => [
            'id' => (int) $k->id,
            'nama' => trim((string) $k->nama),
            'kemasan' => (string) $k->kemasan,
            'harga' => (float) $k->harga,
            'deskripsi' => $k->deskripsi,
            'komposisi' => $k->komposisi,
            'best' => (int) $k->best,
            'tampil' => (int) $k->tampil,
            'gambar' => isset($gambar[$k->id]) ? $gambar[$k->id]->map(fn ($g) => "{$g->id}.{$g->ext}")->all() : null,
            'varian' => isset($varian[$k->id])
                ? $varian[$k->id]->map(fn ($v) => ['nama' => $v->nama_varian, 'harga' => $v->harga !== null ? (float) $v->harga : null])->all()
                : null,
            'terjual' => $terjual[$k->id] ?? 0,
        ])->all();
    }
}
