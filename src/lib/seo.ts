/** JSON-LD Schema.org: Bakery per outlet, Product, Breadcrumb, FAQ. */
import { OUTLET, SITUS, alamatLengkap, type Outlet } from '@/config/situs';
import type { Produk } from './types';

const urlAbs = (p: string) => new URL(p, SITUS.url).toString();

export function schemaOutlet(o: Outlet) {
  return {
    '@type': 'Bakery',
    '@id': urlAbs(`/outlet/#${o.id}`),
    name: o.nama,
    brand: { '@type': 'Brand', name: SITUS.namaLengkap },
    url: urlAbs('/outlet/'),
    image: urlAbs('/og.png'),
    servesCuisine: 'Kue kering, cake, hampers',
    priceRange: 'Rp 23.000 - Rp 400.000',
    address: {
      '@type': 'PostalAddress',
      streetAddress: o.jalan,
      addressLocality: o.kota,
      addressRegion: o.provinsi,
      postalCode: o.kodePos,
      addressCountry: 'ID',
    },
    ...(o.geo && { geo: { '@type': 'GeoCoordinates', latitude: o.geo.lat, longitude: o.geo.lng } }),
    ...((o.whatsapp || SITUS.whatsapp) && { telephone: `+${o.whatsapp || SITUS.whatsapp}` }),
    ...(o.jam.length && {
      openingHoursSpecification: o.jam.map((j) => ({
        '@type': 'OpeningHoursSpecification', dayOfWeek: j.schemaHari, opens: j.buka, closes: j.tutup,
      })),
    }),
    hasMap: `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(alamatLengkap(o))}`,
  };
}

export const schemaBisnis = () => ({
  '@context': 'https://schema.org',
  '@graph': [
    {
      '@type': 'Organization',
      '@id': urlAbs('/#organisasi'),
      name: SITUS.namaLengkap,
      alternateName: SITUS.nama,
      url: SITUS.url,
      logo: urlAbs('/favicon.svg'),
      ...(SITUS.instagram && { sameAs: [`https://instagram.com/${SITUS.instagram}`] }),
      department: OUTLET.map((o) => ({ '@id': urlAbs(`/outlet/#${o.id}`) })),
    },
    ...OUTLET.map(schemaOutlet),
  ],
});

export function schemaProduk(p: Produk) {
  const harga = p.varian.map((v) => v.harga).filter((h): h is number => h != null);
  return {
    '@context': 'https://schema.org',
    '@type': 'Product',
    name: `${p.nama} Teratai Cookies`,
    description: p.deskripsi || p.ringkas,
    category: p.kategori,
    brand: { '@type': 'Brand', name: SITUS.namaLengkap },
    url: urlAbs(`/produk/${p.slug}/`),
    image: p.foto.filter((f) => f.src).map((f) => f.src).concat(urlAbs('/og.png')).slice(0, 3),
    ...(harga.length && {
      offers: {
        '@type': 'AggregateOffer',
        priceCurrency: 'IDR',
        lowPrice: Math.min(...harga),
        highPrice: Math.max(...harga),
        offerCount: p.varian.length,
        availability: 'https://schema.org/InStock',
        seller: { '@id': urlAbs('/#organisasi') },
      },
    }),
  };
}

export const schemaBreadcrumb = (jejak: { nama: string; href: string }[]) => ({
  '@context': 'https://schema.org',
  '@type': 'BreadcrumbList',
  itemListElement: jejak.map((j, i) => ({ '@type': 'ListItem', position: i + 1, name: j.nama, item: urlAbs(j.href) })),
});

export const schemaFaq = (daftar: { t: string; j: string }[]) => ({
  '@context': 'https://schema.org',
  '@type': 'FAQPage',
  mainEntity: daftar.map((q) => ({ '@type': 'Question', name: q.t, acceptedAnswer: { '@type': 'Answer', text: q.j } })),
});
