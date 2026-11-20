{{-- Deretan produk: digeser di HP (scroll-snap, tanpa autoplay), grid 3 kolom di desktop. --}}
@props(['label'])
<div class="rak" data-rak>
    <div class="rak__jalur" role="region" aria-label="{{ $label }}" tabindex="0" data-rak-jalur>
        {{ $slot }}
    </div>
</div>
