@props([
    'judul',              // tanpa nama brand; brand ditambahkan otomatis
    'deskripsi',
    'hal' => 'umum',      // nama halaman, untuk class body (gaya per halaman)
    'gambar' => 'og.png',
    'jsonLd' => [],
    'tipeOg' => 'website',
    'noindex' => false,
])
@php
    $judulPenuh = str_contains($judul, 'Teratai') ? $judul : "$judul | Teratai Cookies Makassar";
    $kanonik = rtrim(config('teratai.url'), '/').'/'.ltrim(request()->path() === '/' ? '' : request()->path(), '/');
    $ogGambar = rtrim(config('teratai.url'), '/').'/'.$gambar;
    $daftarLd = isset($jsonLd['@context']) || isset($jsonLd['@graph']) ? [$jsonLd] : $jsonLd;
@endphp
<!doctype html>
<html lang="id" data-musim="{{ $musimAktif }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>{{ $judulPenuh }}</title>
    <meta name="description" content="{{ $deskripsi }}">
    <link rel="canonical" href="{{ $kanonik }}">
    @if ($noindex)<meta name="robots" content="noindex">@endif
    <meta name="theme-color" content="#FBF8F4">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="sitemap" href="{{ route('sitemap') }}">

    <meta property="og:type" content="{{ $tipeOg }}">
    <meta property="og:site_name" content="{{ config('teratai.nama_lengkap') }}">
    <meta property="og:locale" content="id_ID">
    <meta property="og:title" content="{{ $judulPenuh }}">
    <meta property="og:description" content="{{ $deskripsi }}">
    <meta property="og:url" content="{{ $kanonik }}">
    <meta property="og:image" content="{{ $ogGambar }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @foreach ($daftarLd as $ld)
        <script type="application/ld+json">{!! json_encode($ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
    @endforeach
</head>
<body class="hal-{{ $hal }}">
    <a class="lewati" href="#konten">Langsung ke konten</a>
    <x-header />
    <main id="konten" tabindex="-1">
        {{ $slot }}
    </main>
    <x-footer />
    <x-cart-drawer />
    <x-wa-fab />
</body>
</html>
