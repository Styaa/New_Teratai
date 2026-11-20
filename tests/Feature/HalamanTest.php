<?php

namespace Tests\Feature;

use Tests\TestCase;

class HalamanTest extends TestCase
{
    public static function halaman(): array
    {
        return [['/'], ['/produk'], ['/produk/nastar'], ['/produk/chiffon-cake-20-cm'], ['/hampers'], ['/reseller'], ['/outlet'], ['/tentang'], ['/faq']];
    }

    /** @dataProvider halaman */
    public function test_halaman_bisa_dibuka(string $url): void
    {
        $this->get($url)->assertOk()->assertSee('<title>', false)->assertSee('name="description"', false);
    }

    public function test_halaman_tidak_ada_404(): void
    {
        $this->get('/tidak-ada')->assertNotFound();
        $this->get('/produk/tidak-ada')->assertNotFound();
    }

    public function test_detail_menampilkan_harga_per_kemasan_dan_schema_product(): void
    {
        $this->get('/produk/nastar')
            ->assertSee('Toples Bulat')
            ->assertSee('Rp 90.000')
            ->assertSee('data-harga="90000"', false)
            ->assertSee('"@type":"Product"', false)
            ->assertSee('"lowPrice":30000', false);
    }

    public function test_beranda_berisi_schema_bakery_untuk_dua_outlet(): void
    {
        $res = $this->get('/')->assertOk();
        $this->assertSame(2, substr_count($res->getContent(), '"@type":"Bakery"'));
        $res->assertSee('Jl. Pelita Raya No. 28')->assertSee('Jl. Aroeppala No. 6');
    }

    public function test_katalog_bisa_difilter_tanpa_reload(): void
    {
        $this->get('/produk')->assertSee('data-kategori="kue-kering"', false)->assertSee('data-cari', false)->assertSee('data-urut', false);
    }

    public function test_sitemap_dan_robots(): void
    {
        $this->get('/sitemap.xml')->assertOk()->assertHeader('Content-Type', 'application/xml; charset=utf-8')->assertSee('/produk/nastar');
        $this->get('/robots.txt')->assertOk()->assertSee('Sitemap:');
    }

    public function test_harga_reseller_tidak_pernah_tampil(): void
    {
        foreach (['/', '/produk', '/produk/nastar', '/reseller'] as $url) {
            $this->get($url)->assertDontSee('harga_reseller');
        }
    }

    public function test_klaim_belum_pasti_ditandai(): void
    {
        $this->get('/faq')->assertSee('<span class="tanda">[perlu konfirmasi', false)->assertDontSee('Bersertifikat halal');
        $this->get('/')->assertSee('[contoh]');
    }
}
