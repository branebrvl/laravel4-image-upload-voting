@extends('layouts.main');

@section('title', $image->pageTitle)

@section('description', $image->pageDescription)

@section('scripts')
    <script src="{{ url('js/vendor/highlight.pack.js')}}"></script>
    <script type="text/javascript">
    (function($) {
        hljs.tabReplace = '  ';
        hljs.initHighlightingOnLoad();
        $('[data-toggle=tooltip]').tooltip();
    })(jQuery);
    </script>
    @if(Auth::check())
    <script>
    (function(e){e(".js-like-trick").click(function(t){t.preventDefault();var n=e(this).data("liked")=="0";var r={_token:"{{ csrf_token() }}"};e.post('{{ route("images.like", $image->slug) }}',r,function(t){if(t!="error"){if(!n){e(".js-like-trick .fa").removeClass("text-primary");e(".js-like-trick").data("liked","0");e(".js-like-status").html("Like this?")}else{e(".js-like-trick .fa").addClass("text-primary");e(".js-like-trick").data("liked","1");e(".js-like-status").html("You like this")}e(".js-like-count").html(t+" likes")}})})})(jQuery)
    </script>
    @endif
@stop

@section('content')
  <section class="render-profile">
    <div class="container">
    <div class="row">
      <div class="media">
        @if(Auth::check() && (Auth::user()->id == $image->user_id))
            <div class="pull-right">
                <a class="btn btn-primary" data-toggle="modal" href="#deleteModal">Delete</a> |
                <a class="btn btn-primary" href="{{$image->editLink}}">Edit</a>
                @include('render.delete',['link'=>$image->deleteLink])
            </div>
        @endif
        <a href="#" class="pull-left"><img src="{{ $image->user->photocss }}" alt=""></a>
          <div class="media-body">
            <h2 class="render-title">{{ $image->title }}</h2>
            <ul>
              <li>
                <span class="time"></span> {{ $image->timeago }}
              </li>
              <li>
                <span>by</span> <a href="{{ route('user.profile', $image->user->username) }}">{{ $image->user->username }}</a>
              </li>
            </ul>
          </div> <!-- / .media-body -->
       </div><!-- / .media -->

      <article class="the-render">
        <div>
          {{HTML::image($image->img_big, 'render', ['id'=>'renderimg'])}}
        </div>            
      </article><!-- / .render -->
      <article class="render-meta">

        <ul>
          <a href="#" class="js-like-trick" data-liked="{{ $image->likedByUser(Auth::user()) ? '1' : '0'}}">
            <li class="@if($image->likedByUser(Auth::user())) text-primary @endif">
              <span class="fav"></span>
              <span class="js-like-count">
                  {{ $image->vote_cache }} {{ Str::plural('like', $image->vote_cache) }}
              </span>
              @if(Auth::check())
              <span class="js-like-status">
                  @if($image->likedByUser(Auth::user()))
                      You like this
                  @else
                      Like this?
                  @endif
              </span>
              @endif
            </li>
          </a>
          <li>
            <span class="views"></span>
            <span>
              {{ $image->view_cache }} views
            </span>
          </li>
        </ul><!-- / .render-tools -->

        @if(count($image->tags))
          <div class="tags-section">
            <h5>Tags</h5>
            <ul>
              @foreach($image->tags as $tag)
              <a href="{{ route('images.browse.tag', $tag->slug) }}"><li>{{ $tag->name }}</li></a>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="render-meta-links">
          @if($prev)
              <a  href="{{ route('images.show', $prev->slug) }}"
                  title="{{ $prev->title }}"
                  class="btn btn-sm btn-primary">
                      &laquo; Previous Trick
              </a>
          @endif

          @if($next)
              <a  href="{{ route('images.show', $next->slug) }}"
                  title="{{ $next->title }}"
                  class="btn btn-sm btn-primary pull-right">
                      Next Trick &raquo;
              </a>
          @endif
        </div>
      </article><!-- / .render -->
      <section>
        <h2>Description</h2>
        <div>
          <p>{{{ $image->description }}}</p>
        </div>
      </section><!-- / .render-description -->
    </div><!-- / .row -->
    </div><!-- / .container -->
  </section><!-- / .render-profile -->
@stop
