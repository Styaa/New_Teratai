{{-- Bar pengumuman musiman (satu baris). Teks di config/teratai.php → musim_daftar.*.pengumuman --}}
<div class="pengumuman" role="note">
    @foreach (config('teratai.musim_daftar') as $id => $m)
        <p data-musim-isi="{{ $id }}" @if ($id !== $musimAktif) hidden @endif style="margin:0">
            {{ $m['pengumuman'] }} <a href="{{ route('hampers') }}">{{ $m['banner']['cta'] }}</a>
        </p>
    @endforeach
</div>
