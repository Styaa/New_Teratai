<?php

namespace App\Support;

use App\Katalog\Produk;

/** JSON-LD Schema.org: Bakery per outlet, Product, Breadcrumb, FAQ. */
final class Seo
{
    private static function abs(string $path): string
    {
        return rtrim(config('teratai.url'), '/').'/'.ltrim($path, '/');
    }

    public static function outlet(array $o): array
    {
        $wa = $o['whatsapp'] ?: config('teratai.whatsapp');

        return array_filter([
            '@type' => 'Bakery',
            '@id' => self::abs("outlet#{$o['id']}"),
            'name' => $o['nama'],
            'brand' => ['@type' => 'Brand', 'name' => config('teratai.nama_lengkap')],
            'url' => self::abs('outlet'),
            'image' => self::abs('og.png'),
            'servesCuisine' => 'Kue kering, cake, hampers',
            'priceRange' => 'Rp 23.000 - Rp 400.000',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $o['jalan'],
                'addressLocality' => $o['kota'],
                'addressRegion' => $o['provinsi'],
                'postalCode' => $o['kode_pos'],
                'addressCountry' => 'ID',
            ],
            'geo' => $o['geo'] ? ['@type' => 'GeoCoordinates', 'latitude' => $o['geo']['lat'], 'longitude' => $o['geo']['lng']] : null,
            'telephone' => $wa ? "+{$wa}" : null,
            'openingHoursSpecification' => $o['jam'] ? array_map(fn ($j) => [
                '@type' => 'OpeningHoursSpecification', 'dayOfWeek' => $j['schema_hari'], 'opens' => $j['buka'], 'closes' => $j['tutup'],
            ], $o['jam']) : null,
            'hasMap' => 'https://www.google.com/maps/search/?api=1&query='.rawurlencode(alamat_lengkap($o)),
        ]);
    }

    public static function bisnis(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                array_filter([
                    '@type' => 'Organization',
                    '@id' => self::abs('#organisasi'),
                    'name' => config('teratai.nama_lengkap'),
                    'alternateName' => config('teratai.nama'),
                    'url' => config('teratai.url'),
                    'logo' => self::abs('favicon.svg'),
                    'sameAs' => config('teratai.instagram') ? ['https://instagram.com/'.config('teratai.instagram')] : null,
                    'department' => array_map(fn ($o) => ['@id' => self::abs("outlet#{$o['id']}")], config('teratai.outlet')),
                ]),
                ...array_map([self::class, 'outlet'], config('teratai.outlet')),
            ],
        ];
    }

    public static function produk(Produk $p): array
    {
        $gambar = array_values(array_filter(array_column($p->foto, 'src')));

        return array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => "{$p->nama} Teratai Cookies",
            'description' => $p->deskripsi ?: $p->ringkas,
            'category' => config("katalog.kategori.{$p->kategori}"),
            'brand' => ['@type' => 'Brand', 'name' => config('teratai.nama_lengkap')],
            'url' => self::abs("produk/{$p->slug}"),
            'image' => array_slice([...$gambar, self::abs('og.png')], 0, 3),
            'offers' => $p->hargaMulai() ? [
                '@type' => 'AggregateOffer',
                'priceCurrency' => 'IDR',
                'lowPrice' => $p->hargaMulai(),
                'highPrice' => $p->hargaTertinggi(),
                'offerCount' => count($p->varian),
                'availability' => 'https://schema.org/InStock',
                'seller' => ['@id' => self::abs('#organisasi')],
            ] : null,
        ]);
    }

    /** @param list<array{nama:string, url:string}> $jejak */
    public static function breadcrumb(array $jejak): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => array_map(fn ($j, $i) => [
                '@type' => 'ListItem', 'position' => $i + 1, 'name' => $j['nama'], 'item' => $j['url'],
            ], $jejak, array_keys($jejak)),
        ];
    }

    /** @param list<array{t:string, j:string}> $daftar  hanya jawaban final yang dimasukkan */
    public static function faq(array $daftar): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array_map(fn ($q) => [
                '@type' => 'Question', 'name' => $q['t'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $q['j']],
            ], array_values(array_filter($daftar, fn ($q) => ! str_contains($q['j'], '[perlu konfirmasi')))),
        ];
    }
}
