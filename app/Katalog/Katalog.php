<?php

namespace App\Katalog;

use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Support\Collection;

/** Akses katalog untuk controller & view. Hasil di-cache (config teratai.katalog.cache_detik). */
final class Katalog
{
    /** @var Collection<int, Produk>|null */
    private ?Collection $memo = null;

    public function __construct(
        private readonly SumberKatalog $sumber,
        private readonly PembangunKatalog $pembangun,
        private readonly Cache $cache,
        private readonly int $cacheDetik = 600,
    ) {}

    /** Semua produk yang tampil di website. @return Collection<int, Produk> */
    public function semua(): Collection
    {
        return $this->memo ??= collect(
            $this->cache->remember('teratai.katalog.v1', $this->cacheDetik, function () {
                $produk = array_values(array_filter($this->pembangun->bangun($this->sumber->baris()), fn (Produk $p) => $p->tampil));

                return array_map(fn (Produk $p) => serialize($p), $produk);
            })
        )->map(fn (string $s) => unserialize($s, ['allowed_classes' => [Produk::class]]));
    }

    public function cari(string $slug): ?Produk
    {
        return $this->semua()->first(fn (Produk $p) => $p->slug === $slug);
    }

    /** @return Collection<int, Produk> */
    public function kategori(string $kategori): Collection
    {
        return $this->semua()->where('kategori', $kategori)->values();
    }

    /** Favorit, diurutkan dari yang paling laris. @return Collection<int, Produk> */
    public function terlaris(): Collection
    {
        return $this->semua()->where('best', true)->sortBy('peringkat')->values();
    }

    /** Koleksi unggulan per musim (maks 4). @return Collection<int, Produk> */
    public function koleksiMusim(string $musim): Collection
    {
        if ($musim === 'reguler') {
            $hampers = $this->kategori('hampers')->filter(fn ($p) => ! $p->musim)->sortBy('peringkat')->take(3);

            return $hampers->concat($this->terlaris())->take(4)->values();
        }
        $hampers = $this->kategori('hampers')->filter(fn ($p) => in_array($musim, $p->musim, true))->sortBy(fn ($p) => $p->hargaMulai())->values();
        $kue = $this->kategori('kue-kering')->filter(fn ($p) => in_array($musim, $p->musim, true))->sortBy('peringkat')->values();

        return $kue->take(2)->concat($hampers->take(2))->concat($kue->slice(2))->take(4)->values();
    }

    /** Rekomendasi: kategori sama, favorit dulu, lalu terlaris. @return Collection<int, Produk> */
    public function rekomendasi(Produk $produk, int $jumlah = 8): Collection
    {
        return $this->kategori($produk->kategori)
            ->reject(fn ($p) => $p->slug === $produk->slug)
            ->sortBy([fn ($a, $b) => $b->best <=> $a->best, fn ($a, $b) => $a->peringkat <=> $b->peringkat])
            ->take($jumlah)->values();
    }

    public function lupakan(): void
    {
        $this->cache->forget('teratai.katalog.v1');
        $this->memo = null;
    }
}
