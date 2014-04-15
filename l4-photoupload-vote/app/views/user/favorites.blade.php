@extends('layouts.main')

@section('title','My Favorites')

@section('content')
<section class="browse-recent">
  <div class="container">
    <h2 class="page-title">My Favorites</h2>
    @include('render.grid', [ 'images' => $images ])
  </div><!-- / .container -->
</section><!-- / .browse-recent -->
@stop
