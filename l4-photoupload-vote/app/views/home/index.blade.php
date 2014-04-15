@extends('layouts.main')

@section('title','Welcome')

@section('content')
  <section class="home-banner">
    <div class="container">
      <header class="introduction">
        <h1>If you have to think about a technique you haven't done it enough.</h1>
        <div class="home-banner-links">
				  @if(Auth::guest())
          <a href="{{ url('register') }}">Sign Up</a>
          @endif
          <a href="{{ route('browse.recent') }}">Start Browsing</a>
        </div>
      </header><!-- / .introduction -->
    </div>
  </section><!-- / .home-banner -->

  <section class="home-popular">
      <div class="container">
        <h2>Latest Renders</h2>
        @include('render.grid', ['images' => $images])
      </div><!-- / .container -->
  </section><!-- / .home-popular -->
@stop
