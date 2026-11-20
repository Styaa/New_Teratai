{{--
  Logo Jo&S Teratai Cookies & Cake.
  Bila file logo asli ada di public/logo.svg|webp|png, file itu yang dipakai; bila belum, gambar ulang tanda teratai.
  Wordmark memakai warna espresso (bukan emas) agar terbaca di latar cream (kontras AA).
--}}
@props(['terang' => false])
@php($fileAsli = collect(['logo.svg', 'logo.webp', 'logo.png'])->first(fn ($f) => is_file(public_path($f))))
<span @class(['logo', 'logo--terang' => $terang])>
    @if ($fileAsli)
        <img class="logo__gambar" src="/{{ $fileAsli }}" alt="" width="44" height="44">
    @else
        <x-tanda-teratai class="logo__ikon" />
    @endif
    <span class="logo__teks">
        <span class="logo__jos">Jo&amp;S</span>
        <span class="logo__nama">Teratai</span>
        <span class="logo__sub">Cookies &amp; Cake</span>
    </span>
</span>
