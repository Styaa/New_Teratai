import type { APIRoute } from 'astro';
import { SITUS } from '@/config/situs';
import { getKatalog } from '@/lib/katalog';

const STATIS = ['/', '/produk/', '/hampers/', '/reseller/', '/outlet/', '/tentang/', '/faq/'];

export const GET: APIRoute = async () => {
  const produk = await getKatalog();
  const tgl = new Date().toISOString().slice(0, 10);
  const url = [...STATIS, ...produk.map((p) => `/produk/${p.slug}/`)]
    .map((p) => `  <url><loc>${new URL(p, SITUS.url)}</loc><lastmod>${tgl}</lastmod></url>`)
    .join('\n');
  return new Response(
    `<?xml version="1.0" encoding="UTF-8"?>\n<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n${url}\n</urlset>\n`,
    { headers: { 'Content-Type': 'application/xml; charset=utf-8' } },
  );
};
