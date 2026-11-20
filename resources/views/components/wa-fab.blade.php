{{-- Tombol WhatsApp melayang. Di HP selalu terlihat; tombol "Pesanan" muncul bila keranjang berisi. --}}
<div class="fab">
    <button type="button" class="fab__keranjang" data-buka-keranjang data-fab-keranjang hidden>
        <x-icon nama="keranjang" :ukuran="22" />
        <span>Pesanan</span>
        <span class="fab__jumlah angka" data-jumlah-keranjang>0</span>
    </button>
    <a class="fab__wa" href="{{ link_wa(config('teratai.whatsapp'), 'Halo Teratai Cookies, saya mau tanya tentang kue.') }}" target="_blank" rel="noopener" aria-label="Chat WhatsApp Teratai Cookies">
        <x-icon nama="whatsapp" :ukuran="26" />
    </a>
</div>
