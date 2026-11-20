/**
 * Formulir yang dikirim sebagai pesan WhatsApp (tanpa server).
 * <form data-form-wa data-pembuka="Halo, saya mau ..." data-wa="62xxx"> dengan <label for> pada tiap bidang.
 */
import { formatTanggal, linkWa } from '@/lib/pesan-wa';

document.querySelectorAll<HTMLFormElement>('form[data-form-wa]').forEach((form) => {
  form.noValidate = true;
  form.addEventListener('input', (e) => {
    const el = e.target as HTMLInputElement;
    if (el.getAttribute('aria-invalid') === 'true' && el.checkValidity()) {
      el.setAttribute('aria-invalid', 'false');
      const g = form.querySelector<HTMLElement>(`[data-galat-untuk="${el.name}"]`);
      if (g) g.hidden = true;
    }
  });
  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const bidang = [...form.querySelectorAll<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>('input, select, textarea')]
      .filter((el) => el.name && el.type !== 'submit');

    let pertamaSalah: HTMLElement | null = null;
    for (const el of bidang) {
      const galat = form.querySelector<HTMLElement>(`[data-galat-untuk="${el.name}"]`);
      const salah = !el.checkValidity();
      el.setAttribute('aria-invalid', String(salah));
      if (galat) { galat.hidden = !salah; if (salah) el.setAttribute('aria-describedby', galat.id); }
      if (salah && !pertamaSalah) pertamaSalah = el;
    }
    if (pertamaSalah) { pertamaSalah.focus(); return; }

    const baris = [form.dataset.pembuka ?? 'Halo Teratai Cookies,', ''];
    const sudahRadio = new Set<string>();
    for (const el of bidang) {
      if ((el.type === 'radio' || el.type === 'checkbox')) {
        if (sudahRadio.has(el.name)) continue;
        sudahRadio.add(el.name);
        const dipilih = [...form.querySelectorAll<HTMLInputElement>(`[name="${el.name}"]:checked`)].map((x) => x.dataset.label ?? x.value);
        const legend = el.closest('fieldset')?.querySelector('legend')?.textContent?.trim() ?? el.name;
        if (dipilih.length) baris.push(`${legend}: ${dipilih.join(', ')}`);
        continue;
      }
      const nilai = el.value.trim();
      if (!nilai) continue;
      const label = form.querySelector(`label[for="${el.id}"]`)?.childNodes[0]?.textContent?.trim() ?? el.name;
      baris.push(`${label}: ${el.type === 'date' ? formatTanggal(nilai) : nilai}`);
    }
    baris.push('', 'Terima kasih.');
    window.open(linkWa(form.dataset.wa ?? '', baris.join('\n')), '_blank', 'noopener');
  });
});
