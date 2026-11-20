{{--
  Foto produk / suasana. Bila src kosong, tampil placeholder bertanda jelas "[Foto]".
  Saat foto asli tersedia: isi KATALOG_FOTO_BASE (foto produk dari admin, sebaiknya WebP),
  atau simpan foto suasana di public/img dan isi atribut src.
--}}
@props([
    'foto',                 // ['src' => ?string, 'alt' => string, 'label' => string]
    'rasio' => '4 / 5',
    'jenis' => 'kue',       // kue | toples | cake | hampers | dapur | tim | hero
    'sizes' => '(min-width: 1024px) 25vw, 50vw',
    'eager' => false,
    'label' => true,
])
@php
    $ilustrasi = [
        'kue' => '<g fill="none" stroke="currentColor" stroke-width="1.4"><circle cx="70" cy="86" r="30"/><circle cx="70" cy="86" r="21" stroke-dasharray="2 5"/><circle cx="128" cy="68" r="24"/><circle cx="128" cy="68" r="15" stroke-dasharray="2 5"/><circle cx="122" cy="122" r="20"/><circle cx="122" cy="122" r="12" stroke-dasharray="2 5"/></g><g fill="currentColor"><circle cx="62" cy="80" r="1.6"/><circle cx="77" cy="92" r="1.6"/><circle cx="132" cy="62" r="1.4"/><circle cx="118" cy="118" r="1.4"/></g>',
        'toples' => '<g fill="none" stroke="currentColor" stroke-width="1.4"><rect x="62" y="42" width="76" height="14" rx="5"/><path d="M58 56h84v8c6 4 8 10 8 16v44a14 14 0 0 1-14 14H64a14 14 0 0 1-14-14V80c0-6 2-12 8-16v-8Z"/><circle cx="80" cy="96" r="11"/><circle cx="106" cy="92" r="10"/><circle cx="96" cy="116" r="10"/><circle cx="122" cy="114" r="9"/></g>',
        'cake' => '<g fill="none" stroke="currentColor" stroke-width="1.4"><ellipse cx="100" cy="74" rx="52" ry="14"/><path d="M48 74v44c0 8 23 14 52 14s52-6 52-14V74"/><path d="M48 96c0 8 23 14 52 14s52-6 52-14"/><path d="M100 46v14M96 50h8"/></g>',
        'hampers' => '<g fill="none" stroke="currentColor" stroke-width="1.4"><rect x="50" y="76" width="100" height="62" rx="6"/><path d="M44 66h112v12H44zM100 66v72"/><path d="M100 66c-8-16-30-18-28-6 2 8 18 6 28 6Zm0 0c8-16 30-18 28-6-2 8-18 6-28 6Z"/></g>',
        'dapur' => '<g fill="none" stroke="currentColor" stroke-width="1.4"><path d="M56 112h88M64 112V88a36 36 0 0 1 72 0v24"/><path d="M100 52v-8M84 60l-4-6M116 60l4-6"/><circle cx="100" cy="92" r="6"/></g>',
        'tim' => '<g fill="none" stroke="currentColor" stroke-width="1.4"><circle cx="76" cy="78" r="14"/><path d="M50 132c0-16 12-28 26-28s26 12 26 28"/><circle cx="126" cy="74" r="16"/><path d="M98 132c0-18 12-32 28-32s28 14 28 32"/></g>',
        'hero' => '<g fill="none" stroke="currentColor" stroke-width="1.2"><circle cx="76" cy="96" r="34"/><circle cx="76" cy="96" r="24" stroke-dasharray="2 5"/><circle cx="136" cy="72" r="26"/><circle cx="136" cy="72" r="17" stroke-dasharray="2 5"/><circle cx="132" cy="132" r="22"/><circle cx="132" cy="132" r="14" stroke-dasharray="2 5"/><path d="M30 160c40-10 100-10 140 0" stroke-dasharray="1 6"/></g>',
    ];
@endphp
@if (! empty($foto['src']))
    <img {{ $attributes->class('foto') }} src="{{ $foto['src'] }}" alt="{{ $foto['alt'] }}" sizes="{{ $sizes }}"
         loading="{{ $eager ? 'eager' : 'lazy' }}" @if ($eager) fetchpriority="high" @endif decoding="async"
         width="800" height="1000" style="aspect-ratio: {{ $rasio }}">
@else
    <div {{ $attributes->class(['foto', 'foto--placeholder', "foto--$jenis"]) }} style="aspect-ratio: {{ $rasio }}" role="img" aria-label="Placeholder foto: {{ $foto['alt'] }}">
        <svg viewBox="0 0 200 180" aria-hidden="true">{!! $ilustrasi[$jenis] ?? $ilustrasi['kue'] !!}</svg>
        @if ($label)<span class="foto__label">[Foto] {{ $foto['label'] }}</span>@endif
    </div>
@endif
