import type { APIRoute } from 'astro';
import { SITUS } from '@/config/situs';

export const GET: APIRoute = () =>
  new Response(`User-agent: *\nAllow: /\n\nSitemap: ${new URL('/sitemap.xml', SITUS.url)}\n`, {
    headers: { 'Content-Type': 'text/plain; charset=utf-8' },
  });
