{{-- Breadcrumb + schema BreadcrumbList. $jejak: [['nama' => ..., 'url' => ...], ...] tanpa Beranda --}}
@props(['jejak'])
@php($semua = [['nama' => 'Beranda', 'url' => route('beranda')], ...$jejak])
<nav class="jejak wadah" aria-label="Jejak halaman">
    <ol>
        @foreach ($semua as $j)
            <li>@if ($loop->last)<span aria-current="page">{{ $j['nama'] }}</span>@else<a href="{{ $j['url'] }}">{{ $j['nama'] }}</a>@endif</li>
        @endforeach
    </ol>
</nav>
<script type="application/ld+json">{!! json_encode(\App\Support\Seo::breadcrumb($semua), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
