{{-- Ikon garis tipis (stroke 1.6). Tambah ikon baru di config/ikon.php --}}
@props(['nama', 'ukuran' => 24, 'label' => null])
<svg {{ $attributes }} width="{{ $ukuran }}" height="{{ $ukuran }}" viewBox="0 0 24 24" fill="none" stroke="currentColor"
     stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" focusable="false"
     @if ($label) role="img" aria-label="{{ $label }}" @else aria-hidden="true" @endif>{!! config("ikon.$nama") !!}</svg>
