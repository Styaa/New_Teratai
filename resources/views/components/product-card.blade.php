@props(['produk', 'eager' => false, 'musim' => false, 'tingkat' => 'h3'])
@php($p = $produk)
<article class="kartu" data-kartu data-kategori="{{ $p->kategori }}"
         data-nama="{{ mb_strtolower($p->nama.' '.implode(' ', array_column($p->varian, 'nama')).' '.($p->merek ?? '')) }}"
         data-harga="{{ $p->hargaMulai() ?? 0 }}" data-peringkat="{{ $p->peringkat }}" data-best="{{ $p->best ? 1 : 0 }}">
    <div class="kartu__foto">
        <x-foto :foto="$p->foto[0]" :jenis="$p->jenisFoto()" rasio="4 / 5" :eager="$eager" sizes="(min-width: 1024px) 270px, (min-width: 640px) 33vw, 50vw" />
        <div class="kartu__badge">
            @if ($p->best)<span class="badge badge--favorit">Favorit</span>@endif
            @if ($musim)<span class="badge badge--musim">Musiman</span>@endif
        </div>
    </div>
    <div class="kartu__isi">
        @if ($p->merek)<span class="kartu__merek">{{ $p->merek }}</span>@endif
        <{{ $tingkat }} class="kartu__nama"><a href="{{ $p->url() }}" class="kartu__tautan">{{ $p->nama }}</a></{{ $tingkat }}>
        <p class="kartu__ringkas">{{ $p->ringkas }}</p>
        <p class="kartu__harga harga">{{ $p->labelHarga() }}</p>
        @if (count($p->varian) > 1)<p class="kartu__varian">{{ count($p->varian) }} pilihan {{ mb_strtolower($p->labelVarian) }}</p>@endif
    </div>
</article>
