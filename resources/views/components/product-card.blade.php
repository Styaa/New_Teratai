@props(['produk', 'eager' => false, 'musim' => false, 'tingkat' => 'h3'])
@php($p = $produk)
<article class="kartu" data-kartu data-kategori="{{ $p->kategori }}"
         data-nama="{{ mb_strtolower($p->nama.' '.implode(' ', array_column($p->varian, 'nama')).' '.($p->merek ?? '')) }}"
         data-harga="{{ $p->hargaMulai() ?? 0 }}" data-peringkat="{{ $p->peringkat }}" data-best="{{ $p->best ? 1 : 0 }}">
    <div class="kartu__foto">
        <x-foto :foto="$p->foto[0]" :jenis="$p->jenisFoto()" rasio="4 / 5" :eager="$eager" sizes="(min-width: 768px) 360px, 50vw" />
    </div>
    <div class="kartu__isi">
        <{{ $tingkat }} class="kartu__nama"><a href="{{ $p->url() }}" class="kartu__tautan">{{ $p->nama }}</a></{{ $tingkat }}>
        @if ($p->best || $musim)
            <span class="kartu__meta">{{ collect([$p->best ? 'Favorit' : null, $musim ? 'Edisi musiman' : null])->filter()->join(' · ') }}</span>
        @elseif ($p->merek)
            <span class="kartu__merek">{{ $p->merek }}</span>
        @endif
        <p class="kartu__harga harga">{{ ucfirst($p->labelHarga()) }}</p>
    </div>
</article>
