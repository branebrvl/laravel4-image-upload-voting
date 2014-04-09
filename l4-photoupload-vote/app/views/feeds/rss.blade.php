{{ '<?xml version="1.0" encoding="utf-8"?>' }}

<rss xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">
    <channel>
        <title>Laravel-Tricks</title>
        <link>http://www.laravel-tricks.com</link>
        <atom:link href="{{ Request::url() }}" rel="self"></atom:link>
        <description>Laravel tricks is a website that aggregates useful tips and tricks for Laravel PHP framework</description>
        <language>en-us</language>
        <lastBuildDate>{{ Carbon\Carbon::now()->toRSSString() }}</lastBuildDate>

@foreach($images as $image)
        <item>
            <title>{{ $image->title }}</title>
            <link>{{ route('images.show', $image->slug) }}</link>
            <guid>{{ route('images.show', $image->slug) }}</guid>
            <description><![CDATA[{{ $image->description}}]]></description>
            <pubDate>{{ $image->created_at->toRSSString() }}</pubDate>
        </item>
@endforeach
    </channel>
</rss>
