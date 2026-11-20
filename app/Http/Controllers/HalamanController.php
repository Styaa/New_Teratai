<?php

namespace App\Http\Controllers;

use App\Katalog\Katalog;
use App\Katalog\Produk;
use Illuminate\Http\Response;
use Illuminate\View\View;

class HalamanController extends Controller
{
    public function __construct(private readonly Katalog $katalog) {}

    public function beranda(): View
    {
        $musim = array_keys(config('teratai.musim_daftar'));

        return view('pages.beranda', [
            'terlaris' => $this->katalog->terlaris(),
            'koleksi' => collect($musim)->mapWithKeys(fn ($m) => [$m => $this->katalog->koleksiMusim($m)]),
        ]);
    }

    public function hampers(): View
    {
        $hampers = $this->katalog->kategori('hampers')->sortBy(fn (Produk $p) => $p->hargaMulai());
        $aktif = view()->shared('musimAktif');
        $urutan = collect([$aktif, 'natal', 'imlek', 'lebaran'])->unique()->reject(fn ($m) => $m === 'reguler');

        return view('pages.hampers', [
            'perMusim' => $urutan->map(fn ($m) => [
                'id' => $m,
                'label' => config("teratai.musim_daftar.$m.label"),
                'produk' => $hampers->filter(fn ($p) => in_array($m, $p->musim, true))->values(),
            ])->filter(fn ($g) => $g['produk']->isNotEmpty())->values(),
            'reguler' => $hampers->filter(fn ($p) => ! $p->musim)->values(),
        ]);
    }

    public function reseller(): View
    {
        return view('pages.reseller');
    }

    public function outlet(): View
    {
        return view('pages.outlet');
    }

    public function tentang(): View
    {
        return view('pages.tentang');
    }

    public function faq(): View
    {
        return view('pages.faq', ['grup' => config('faq')]);
    }

    public function sitemap(): Response
    {
        $statis = ['beranda', 'produk.index', 'hampers', 'reseller', 'outlet', 'tentang', 'faq'];
        $url = [...array_map(fn ($r) => route($r), $statis), ...$this->katalog->semua()->map(fn (Produk $p) => $p->url())->all()];

        return response()->view('seo.sitemap', ['url' => $url, 'tanggal' => now()->toDateString()])
            ->header('Content-Type', 'application/xml; charset=utf-8');
    }

    public function robots(): Response
    {
        return response("User-agent: *\nAllow: /\n\nSitemap: ".route('sitemap')."\n")
            ->header('Content-Type', 'text/plain; charset=utf-8');
    }
}
