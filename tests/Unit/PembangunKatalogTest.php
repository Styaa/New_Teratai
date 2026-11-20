<?php

namespace Tests\Unit;

use App\Katalog\PembangunKatalog;
use App\Katalog\Produk;
use App\Katalog\SumberJson;
use Tests\TestCase;

class PembangunKatalogTest extends TestCase
{
    /** @return list<Produk> */
    private function katalog(): array
    {
        $baris = (new SumberJson(database_path('data/katalog-db.json')))->baris();

        return app(PembangunKatalog::class)->bangun($baris);
    }

    private function cari(string $slug): Produk
    {
        return collect($this->katalog())->firstWhere('slug', $slug);
    }

    public function test_satu_rasa_satu_produk_dengan_kemasan_sebagai_varian(): void
    {
        $tampil = collect($this->katalog())->where('tampil', true);
        $this->assertCount(1, $tampil->where('nama', 'Nastar'));

        $nastar = $this->cari('nastar');
        $kemasan = array_column($nastar->varian, 'harga', 'nama');
        $this->assertSame(30000, $kemasan['Mika']);
        $this->assertSame(55000, $kemasan['Toples Tabung Kecil']);
        $this->assertSame(90000, $kemasan['Toples Bulat']);
        $this->assertTrue($nastar->best);
        $this->assertSame('mulai Rp 30.000', $nastar->labelHarga());
    }

    public function test_slug_unik(): void
    {
        $slug = array_map(fn ($p) => $p->slug, $this->katalog());
        $this->assertSame(count($slug), count(array_unique($slug)));
    }

    public function test_tidak_menampilkan_tester_bonus_atau_harga_nol(): void
    {
        foreach (collect($this->katalog())->where('tampil', true) as $p) {
            $this->assertDoesNotMatchRegularExpression('/tester|bonus/i', $p->nama);
            foreach ($p->varian as $v) {
                $this->assertTrue($v['harga'] === null || $v['harga'] > 0, $p->nama);
            }
        }
    }

    public function test_chiffon_digabung_dengan_pilihan_rasa(): void
    {
        $c = $this->cari('chiffon-cake-20-cm');
        $rasa = array_column($c->varian, 'nama');
        sort($rasa);
        $this->assertSame(['Coklat', 'Keju', 'Pandan'], $rasa);
        $this->assertSame(65000, $c->hargaMulai());
    }

    public function test_alergen_dari_komposisi(): void
    {
        $this->assertSame(['gluten', 'telur', 'susu', 'kacang'], PembangunKatalog::deteksiAlergen('Mente: Tepung, Gula, Mentega, Telur'));
        $this->assertNotContains('kacang', PembangunKatalog::deteksiAlergen('Keju: Mentega, Roombutter, Susu'));
    }

    public function test_file_katalog_tidak_berisi_data_reseller(): void
    {
        $this->assertStringNotContainsStringIgnoringCase('reseller', file_get_contents(database_path('data/katalog-db.json')));
    }
}
