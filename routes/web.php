<?php

use App\Http\Controllers\HalamanController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HalamanController::class, 'beranda'])->name('beranda');
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/{slug}', [ProdukController::class, 'show'])->where('slug', '[a-z0-9-]+')->name('produk.show');
Route::get('/hampers', [HalamanController::class, 'hampers'])->name('hampers');
Route::get('/reseller', [HalamanController::class, 'reseller'])->name('reseller');
Route::get('/outlet', [HalamanController::class, 'outlet'])->name('outlet');
Route::get('/tentang', [HalamanController::class, 'tentang'])->name('tentang');
Route::get('/faq', [HalamanController::class, 'faq'])->name('faq');

Route::get('/sitemap.xml', [HalamanController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [HalamanController::class, 'robots'])->name('robots');
