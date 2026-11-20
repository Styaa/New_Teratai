@props(['outlet', 'peta' => false, 'tingkat' => 'h3'])
@php($o = $outlet)
<article class="outlet" id="{{ $o['id'] }}">
    @if ($peta)
        <div class="outlet__peta">
            <iframe src="{{ link_embed_peta($o) }}" title="Peta lokasi {{ $o['nama'] }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
        </div>
    @endif
    <{{ $tingkat }} class="outlet__nama">{{ $o['nama'] }}</{{ $tingkat }}>
    <p>{{ alamat_lengkap($o) }}</p>
    @if ($o['jam'])
        <dl class="outlet__jam">
            @foreach ($o['jam'] as $j)<dt>{{ $j['hari'] }}</dt><dd class="angka">{{ $j['buka'] }}–{{ $j['tutup'] }} WITA</dd>@endforeach
        </dl>
    @else
        <p>Jam buka <span class="tanda">[jam buka {{ $o['nama'] }}]</span></p>
    @endif
    <div class="outlet__aksi">
        <a class="tautan" href="{{ link_petunjuk_arah($o) }}" target="_blank" rel="noopener">Petunjuk arah <x-icon nama="panah" /></a>
        <a class="tautan" href="{{ link_wa($o['whatsapp'] ?: config('teratai.whatsapp'), "Halo {$o['nama']}, saya mau tanya tentang kue.") }}" target="_blank" rel="noopener">
            WhatsApp outlet <x-icon nama="panah" />
        </a>
    </div>
    @if (! $o['whatsapp'])<p class="kecil"><span class="tanda">[nomor WA outlet]</span></p>@endif
</article>
