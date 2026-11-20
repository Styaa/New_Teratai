<?php

namespace App\Providers;

use App\Katalog\Katalog;
use App\Katalog\PembangunKatalog;
use App\Katalog\SumberDatabase;
use App\Katalog\SumberJson;
use App\Katalog\SumberKatalog;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class KatalogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SumberKatalog::class, fn ($app) => match (config('teratai.katalog.sumber')) {
            'db' => new SumberDatabase($app['db']->connection('admin')),
            default => new SumberJson(database_path('data/katalog-db.json')),
        });

        $this->app->singleton(PembangunKatalog::class, fn () => new PembangunKatalog(
            config('katalog'),
            config('konten-produk', []),
            config('teratai.katalog.foto_base', ''),
        ));

        $this->app->singleton(Katalog::class, fn ($app) => new Katalog(
            $app->make(SumberKatalog::class),
            $app->make(PembangunKatalog::class),
            $app['cache.store'],
            config('teratai.katalog.cache_detik', 600),
        ));
    }

    public function boot(): void
    {
        // Musim aktif tersedia di semua view sebagai $musimAktif.
        View::share('musimAktif', array_key_exists(config('teratai.musim'), config('teratai.musim_daftar')) ? config('teratai.musim') : 'reguler');
    }
}
