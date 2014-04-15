@extends('layouts.main')

@section('title', 'Tags')

@section('content')
<section class="tags">
  <div class="container">
    <div class="row">
      <article>
        <h2>Tags</h2>
        <div class="content-box">
          <ul class="nav nav-list">
            @foreach($tags as $tag)
              <li>
                <a href="{{ route('images.browse.tag', $tag->slug) }}">
                  {{ $tag->name }}
                  <span class="text-muted pull-right">{{$tag->image_count}}</span>
                </a>
              </li>
            @endforeach
          </ul>
        </div>
      </article>
    </div><!-- / .row -->
  </div><!-- / .container -->
</section>
@stop
