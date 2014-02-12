@extends('layout')

@section('container')

  @foreach(array_chunk($posts->all(), 3) as $row)
    <div class="row">
      @foreach($row as $post)
        <article class="col-md-3">
          <h2>{{ $post->title  }} </h2>
          <div class="body"> {{ $post -> body  }} </div>
          {{ Form::open(['route' => 'favorites.store'])}}
          {{ Form::hidden('post-id', $post->id)}}
          <button type="submit">
            <i class="fa fa-camera-retro fa-lg"></i>
          </button>
          {{ Form::close() }}
        </article>
      @endforeach
    </div>
  @endforeach

@stop
