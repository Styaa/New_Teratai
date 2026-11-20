/** Pratinjau musim tanpa mengubah .env: tambahkan ?musim=lebaran pada URL. */
export function initMusim() {
  const q = new URLSearchParams(location.search).get('musim');
  if (q && document.querySelector(`[data-musim-isi="${CSS.escape(q)}"]`)) {
    document.documentElement.dataset.musim = q;
    document.querySelectorAll('[data-musim-isi]').forEach((el) => (el.hidden = el.dataset.musimIsi !== q));
  }
}
