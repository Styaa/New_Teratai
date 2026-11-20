{{-- Schema BreadcrumbList untuk SEO (tanpa tampilan; navigasi kembali memakai tautan "← Katalog"). --}}
@props(['jejak'])
@php($semua = [['nama' => 'Beranda', 'url' => route('beranda')], ...$jejak])
<script type="application/ld+json">{!! json_encode(\App\Support\Seo::breadcrumb($semua), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
