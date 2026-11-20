{{--
  Logo Jo&S Teratai Cookies & Cake (versi ringkas untuk header & footer).
  Bila file logo asli ada di public/logo.svg|webp|png, file itu yang dipakai; bila belum, gambar ulang tanda teratai.
--}}
@php($fileAsli = collect(['logo.svg', 'logo.webp', 'logo.png'])->first(fn ($f) => is_file(public_path($f))))
<span class="logo">
    @if ($fileAsli)
        <img class="logo__gambar" src="/{{ $fileAsli }}" alt="" width="32" height="32">
    @else
        <x-tanda-teratai class="logo__ikon" />
    @endif
    <span class="logo__teks">Teratai Cookies</span>
</span>
