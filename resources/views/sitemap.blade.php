<?xml version = "1.0" encoding = "UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($games as $game)
        <url>
            <loc>{{ route('getGame',$game->game_url) }}</loc>
        </url>
    @endforeach
    @foreach ($games as $game)
        <url>
            <loc>{{ route('getGame',$game->game_url) }}</loc>
        </url>
    @endforeach
</urlset>
{{--            <lastmod>{{ $post->updated_at->tz('GMT')->toAtomString() }}</lastmod>--}}
{{--            <changefreq>monthly</changefreq>--}}
{{--            <priority>1</priority>--}}
