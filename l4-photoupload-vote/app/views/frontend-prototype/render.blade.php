<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->

<head>                         
  <meta charset="utf-8">       
  <title>Render</title>
    
  <!-- Mobile Specific Meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <!-- Stylesheets -->         
  <link rel="stylesheet" href="styles/css/index.css" />
  
  <!--[if lt IE 9]>            
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->                 
</head>
<body>
  <nav>
    <div class="container">

      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-contents">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

        <a href="/" class="navbar-brand logo">
          render
        </a>
      </div> <!-- navbar-header -->

      <div class="navbar-collapse collapse" id="navbar-contents">
        <ul class="nav navbar-nav">
          <!-- Browse -->
          <li class="animated slideInDown">
            <a href="#" class="dropdown-toggle navbar-link" data-toggle="dropdown">Browse</a>
          </li>

          <!-- Tags -->
          <li class="animated slideInDown">
            <a href="#" class="dropdown-toggle navbar-link" data-toggle="dropdown">Tags</a>
          </li>

          <!-- Create New-->
          <li class="animated slideInDown">
            <a href="#" class="dropdown-toggle navbar-link" data-toggle="dropdown">Create New</a>
          </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
          <li class=" divided-list"><a href="https://laracasts.com/join">Sign Up</a></li>
          <li class=""><a href="https://laracasts.com/login">Log In</a></li>

          <li class="dropdown" id="user-options">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="http://placehold.it/30x30" class="nav-gravatar" alt="Branislav">                            Branislav <b class="caret"></b>
            </a>

            <ul class="dropdown-menu dropdown-with-icons">
              <li class="">
                <a href="/@Branislav">
                  <i class="icon-eye-open"></i> Profile
                </a>
              </li>

              <li class="">
                <a href="/all">
                  <i class="icon-tasks"></i> Checklist
                </a>
              </li>

              <li class="">
                <a href="/admin/account">
                  <i class="icon-pencil"></i> Settings
                </a>
              </li>

              <li>
                <a href="//laracasts.uservoice.com/">
                 <i class="icon-comment"></i> Requests
                </a>
              </li>

              <li>
                <a href="/logout">
                  <i class="icon-signout"></i> Log Out
                </a>
              </li>
            </ul>
          </li><!-- / #user-option -->

          <!-- Search Bubble -->
          <li>
            <form id="navbar-search-form" class="navbar-form" role="search" action="/search" style="display: block;">
            <input type="text" class="search-query form-control" name="q" id="q" placeholder="Search...">
            </form>
          </li>
        </ul>
      </div> <!-- .collapse -->
    </div> <!-- .container -->
  </nav><!-- / .navbar -->

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
  <section class="render-profile">
    <div class="container">
      <div class="media">
                    @if(Auth::check() && (Auth::user()->id == $image->user_id))
                        <div class="text-right">
                            <a data-toggle="modal" href="#deleteModal">Delete</a> |
                            <a href="{{$image->editLink}}">Edit</a>
                            @include('tricks.delete',['link'=>$image->deleteLink])
                        </div>
                    @endif
        <a href="#" class="pull-left"><img src="{{ $image->user->photocss }}" alt="" class="img-circle media-object"></a>
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
    <div class="row">
      <article class="the-render">
        <div>
          <img alt="" src="{{ $image->img_big }}">
        </div>            
      </article><!-- / .render -->
      <article class="render-meta">

        <ul>
          <a href="#" class="js-like-trick" data-liked="{{ $image->likedByUser(Auth::user()) ? '1' : '0'}}">
            <li class="fav @if($image->likedByUser(Auth::user())) text-primary @endif">
              @if(Auth::check())
              <span class="js-like-status">
                  @if($image->likedByUser(Auth::user()))
                      You like this
                  @else
                      Like this?
                  @endif
              </span>
              <span class="pull-right js-like-count">
              @endif
                  {{ $image->vote_cache }} {{ Str::plural('like', $image->vote_cache) }}
              @if(Auth::check())</span>@endif
            </li>
          </a>
          <li class="views"><span>{{ $image->view_cache }} views</span></li>
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
                  title="{{ $prev->title }}" data-toggle="tooltip"
                  class="btn btn-sm btn-primary">
                      &laquo; Previous Trick
              </a>
          @endif

          @if($next)
              <a  href="{{ route('images.show', $next->slug) }}"
                  title="{{ $next->title }}" data-toggle="tooltip"
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


  <footer>
    <div class="container">
      <div class="row">
        <section>
          <ul class="footer-nav">
            <li>Built with Laravel. Find out more on SI Wiki</li>
          </ul><!-- / .footer-nav -->
        </section><!-- / .side-bar -->
        <section>
          <a class="logo" href="">render</a>
         </section>
      </div><!-- / .row -->
    </div><!-- / .container -->
  </footer><!-- / .footer -->

  <!-- SCRIPTS -->
  <script src="vendor/bower_components/jquery/dist/jquery.js"></script>
  <script src="vendor/bower_components/bootstrap/dist/js/bootstrap.js"></script>
</body>
