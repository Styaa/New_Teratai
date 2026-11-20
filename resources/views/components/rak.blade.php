{{-- Carousel horizontal (scroll-snap) tanpa autoplay. Tombol panah hanya di layar lebar. --}}
@props(['label'])
<div class="rak" data-rak>
    <div class="rak__jalur" role="region" aria-label="{{ $label }}" tabindex="0" data-rak-jalur>
        {{ $slot }}
    </div>
    <div class="rak__kontrol">
        <button type="button" class="rak__btn" data-rak-geser="-1" aria-label="Sebelumnya"><x-icon nama="kiri" /></button>
        <button type="button" class="rak__btn" data-rak-geser="1" aria-label="Berikutnya"><x-icon nama="kanan" /></button>
    </div>
</div>
