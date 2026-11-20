{!! '<'.'?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ($url as $u)
    <url><loc>{{ $u }}</loc><lastmod>{{ $tanggal }}</lastmod></url>
@endforeach
</urlset>
