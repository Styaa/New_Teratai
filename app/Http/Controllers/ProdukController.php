<?php

namespace App\Http\Controllers;

use App\Katalog\Katalog;
use Illuminate\View\View;

class ProdukController extends Controller
{
    public function __construct(private readonly Katalog $katalog) {}

    public function index(): View
    {
        $semua = $this->katalog->semua();

        return view('pages.produk.index', [
            // urutan awal tanpa JS: favorit dulu, lalu terlaris
            'produk' => $semua->sortBy([fn ($a, $b) => $b->best <=> $a->best, fn ($a, $b) => $a->peringkat <=> $b->peringkat])->values(),
            'jumlah' => collect(config('katalog.kategori'))->map(fn ($_, $id) => $semua->where('kategori', $id)->count())->filter(),
        ]);
    }

    public function show(string $slug): View
    {
        $produk = $this->katalog->cari($slug) ?? abort(404);

        return view('pages.produk.show', [
            'p' => $produk,
            'rekomendasi' => $this->katalog->rekomendasi($produk),
        ]);
    }
}
