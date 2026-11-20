/** Tombol "Pesanan" melayang hanya tampil bila keranjang berisi. */
export function initFab() {
  const tombol = document.querySelector('[data-fab-keranjang]');
  const jumlah = tombol?.querySelector('[data-jumlah-keranjang]');
  if (!tombol || !jumlah) return;
  const cek = () => { tombol.hidden = jumlah.hidden || jumlah.textContent === '0'; };
  new MutationObserver(cek).observe(jumlah, { attributes: true, childList: true, characterData: true, subtree: true });
  cek();
}
