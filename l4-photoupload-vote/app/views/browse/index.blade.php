@extends('layouts.main')

@section('title', $pageTitle)

@section('content')
  <section class="browse-recent">
    <div class="container">

      <!-- sub nav -->
      @if(Request::is('popular') || Request::is('recent'))
        <div class="recent">
          <ul>
            {{ Navigation::make(Request::path(), 'browse') }}
          </ul>
        </div><!-- / sub nav -->
      @endif

      <!-- tags browsing-->
      @if(Request::segment('1') == 'tags')
        <h2>{{ $pageTitle }}</h2>
      @endif

      <!-- grid -->
      @include('render.grid', ['images' => $images])

      <!-- Pagination -->
      @if($images->count()) 
          <div class="text-center"> 
            @if(isset($appends)) 
              {{ $images->appends($appends)->links(); }} 
            @else 
              {{ $images->links(); }} 
            @endif 
        </div> <!-- / pagination -->
      @endif 
    </div><!-- / .container -->
  </section><!-- / .browse-recent -->
@stop
