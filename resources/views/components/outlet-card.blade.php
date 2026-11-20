@props(['outlet', 'peta' => false, 'tingkat' => 'h3'])
@php($o = $outlet)
<article class="outlet" id="{{ $o['id'] }}">
    @if ($peta)
        <div class="outlet__peta">
            <iframe src="{{ link_embed_peta($o) }}" title="Peta lokasi {{ $o['nama'] }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
        </div>
    @endif
    <div class="outlet__isi">
        <{{ $tingkat }} class="outlet__nama">{{ $o['nama'] }}</{{ $tingkat }}>
        <p class="outlet__baris"><x-icon nama="pin" :ukuran="20" /> <span>{{ alamat_lengkap($o) }}</span></p>
        <div class="outlet__baris">
            <x-icon nama="jam" :ukuran="20" />
            @if ($o['jam'])
                <dl class="outlet__jam">
                    @foreach ($o['jam'] as $j)<dt>{{ $j['hari'] }}</dt><dd class="angka">{{ $j['buka'] }}–{{ $j['tutup'] }}</dd>@endforeach
                </dl>
            @else
                <span>Jam buka <span class="tanda">[jam buka {{ $o['nama'] }}]</span></span>
            @endif
        </div>
        <div class="outlet__aksi">
            <a class="btn btn--kecil" href="{{ link_petunjuk_arah($o) }}" target="_blank" rel="noopener"><x-icon nama="pin" /> Petunjuk Arah</a>
            <a class="btn btn--garis btn--kecil" href="{{ link_wa($o['whatsapp'] ?: config('teratai.whatsapp'), "Halo {$o['nama']}, saya mau tanya tentang kue.") }}" target="_blank" rel="noopener">
                <x-icon nama="whatsapp" /> WhatsApp Outlet
            </a>
        </div>
        @if (! $o['whatsapp'])<p class="outlet__catatan"><span class="tanda">[nomor WA outlet]</span></p>@endif
    </div>
</article>
