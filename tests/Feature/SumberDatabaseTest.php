<?php

namespace Tests\Feature;

use App\Katalog\SumberDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/** Menguji query ke database admin memakai SQLite in-memory dengan skema tabel admin. */
class SumberDatabaseTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.connections.admin' => ['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '']]);
        DB::purge('admin');
        $s = Schema::connection('admin');
        $s->create('kategori', fn ($t) => [$t->integer('id'), $t->string('nama'), $t->double('harga_reseller')->nullable()]);
        $s->create('kue', fn ($t) => [$t->integer('id'), $t->string('nama'), $t->double('harga'), $t->text('deskripsi')->nullable(),
            $t->integer('kategori_id'), $t->text('komposisi')->nullable(), $t->tinyInteger('best'), $t->tinyInteger('tampil'),
            $t->timestamp('deleted_at')->nullable(), $t->double('harga_reseller')->nullable()]);
        $s->create('gambar', fn ($t) => [$t->integer('id'), $t->string('ext'), $t->integer('kue_id')]);
        $s->create('kue_varian', fn ($t) => [$t->integer('id'), $t->integer('kue_id'), $t->string('nama_varian'), $t->double('harga')->nullable()]);
        $s->create('nota_has_kue', fn ($t) => [$t->integer('kue_id'), $t->integer('jumlah')]);
        $s->create('t_notas_has_kue', fn ($t) => [$t->integer('kue_id'), $t->integer('jumlah')]);

        $db = DB::connection('admin');
        $db->table('kategori')->insert([['id' => 15, 'nama' => 'Mika', 'harga_reseller' => 27000], ['id' => 28, 'nama' => 'Minuman', 'harga_reseller' => null]]);
        $db->table('kue')->insert([
            ['id' => 6, 'nama' => 'Nastar', 'harga' => 30000, 'deskripsi' => '<p>Enak</p>', 'kategori_id' => 15, 'komposisi' => 'Tepung', 'best' => 1, 'tampil' => 1, 'deleted_at' => null, 'harga_reseller' => 24000],
            ['id' => 7, 'nama' => 'Dihapus', 'harga' => 30000, 'deskripsi' => null, 'kategori_id' => 15, 'komposisi' => null, 'best' => 0, 'tampil' => 1, 'deleted_at' => now(), 'harga_reseller' => null],
            ['id' => 8, 'nama' => 'Aqua', 'harga' => 5000, 'deskripsi' => null, 'kategori_id' => 28, 'komposisi' => null, 'best' => 0, 'tampil' => 1, 'deleted_at' => null, 'harga_reseller' => null],
        ]);
        $db->table('gambar')->insert(['id' => 1, 'ext' => 'jpg', 'kue_id' => 6]);
        $db->table('nota_has_kue')->insert([['kue_id' => 6, 'jumlah' => 3], ['kue_id' => 6, 'jumlah' => 2]]);
        $db->table('t_notas_has_kue')->insert(['kue_id' => 6, 'jumlah' => 5]);
    }

    public function test_membaca_katalog_tanpa_kolom_reseller(): void
    {
        DB::connection('admin')->enableQueryLog();
        $baris = (new SumberDatabase(DB::connection('admin')))->baris();

        $this->assertCount(1, $baris, 'produk terhapus & minuman tidak ikut');
        $this->assertSame('Nastar', $baris[0]['nama']);
        $this->assertSame('Mika', $baris[0]['kemasan']);
        $this->assertSame(['1.jpg'], $baris[0]['gambar']);
        $this->assertSame(10, $baris[0]['terjual']);
        $this->assertArrayNotHasKey('harga_reseller', $baris[0]);

        foreach (DB::connection('admin')->getQueryLog() as $q) {
            $this->assertStringNotContainsString('reseller', $q['query']);
            $this->assertStringNotContainsString('*', $q['query']);
        }
    }
}
