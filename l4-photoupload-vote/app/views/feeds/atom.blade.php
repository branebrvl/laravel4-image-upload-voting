{{ '<?xml version="1.0" encoding="utf-8"?>' }}

<feed xmlns="http://www.w3.org/2005/Atom">
    <title>Laravel-Tricks</title>
    <subtitle>Laravel images is a website that aggregates useful tips and images for Laravel PHP framework</subtitle>
    <link href="{{ Request::url() }}" rel="self" />
    <updated>{{ Carbon\Carbon::now()->toATOMString() }}</updated>
    <author>
        <name>Maks Surguy</name>
        <uri>http://twitter.com/msurguy</uri>
    </author>
    <author>
        <name>Stidges</name>
        <uri>http://twitter.com/stidges</uri>
    </author>
    <id>tag:{{ Request::getHost() }},{{ date('Y') }}:/feed.atom</id>

@foreach($images as $image)
    <entry>
        <title>{{ $image->title }}</title>
        <link href="{{ route('images.show', $image->slug) }}" />
        <id>{{ $image->tagUri }}</id>
        <updated>{{ $image->updated_at->toATOMString() }}</updated>
        <summary>{{ $image->description }}</summary>
    </entry>
@endforeach
</feed>
