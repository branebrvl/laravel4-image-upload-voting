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
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-8">
                <div class="content-box">
                    @if(Auth::check() && (Auth::user()->id == $image->user_id))
                        <div class="text-right">
                            <a data-toggle="modal" href="#deleteModal">Delete</a> |
                            <a href="{{$image->editLink}}">Edit</a>
                            @include('tricks.delete',['link'=>$image->deleteLink])
                        </div>
                    @endif
                    <div class="trick-user">
                        <div class="trick-user-image">
                            <img src="{{ $image->user->photocss }}" class="user-avatar">
                        </div>
                        <div class="trick-user-data">
                            <h1 class="page-title">
                                {{ $image->title }}
                            </h1>
                            <div>
                                Submitted by <b><a href="{{ route('user.profile', $image->user->username) }}">{{ $image->user->username }}</a></b> - {{ $image->timeago }}
                            </div>
                        </div>
                    </div>
                    <p>{{{ $image->description }}}</p>
                    {{HTML::image($image->img_big, 'render', ['id'=>'renderimg'])}}
                </div>
            </div>
                <div class="col-lg-3 col-md-4">
                    <div class="content-box">
                        <b>Stats</b>
                        <ul class="list-group trick-stats">
                            <a href="#" class="list-group-item js-like-trick" data-liked="{{ $image->likedByUser(Auth::user()) ? '1' : '0'}}">

                                <span class="fa fa-heart @if($image->likedByUser(Auth::user())) text-primary @endif"></span>
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
                            </a>
                            <li class="list-group-item">
                                <span class="fa fa-eye"></span> {{ $image->view_cache }} views
                            </li>
                        </ul>
                        @if(count($image->allCategories))
                            <b>Categories</b>
                            <ul class="nav nav-list push-down">
                                @foreach($image->allCategories as $category)
                                    <li>
                                        <a href="{{ route('images.browse.category', $category->slug) }}">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        @if(count($image->tags))
                            <b>Tags</b>
                            <ul class="nav nav-list push-down">
                                @foreach($image->tags as $tag)
                                    <li>
                                        <a href="{{ route('images.browse.tag', $tag->slug) }}">
                                            {{ $tag->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <div class="clearfix">
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
                    </div>
                </div>
            </div>
                <div class="row">
                    <div class="col-lg-9 col-md-8">
                        <div id="disqus_thread"></div>
                        <script type="text/javascript">
                            var disqus_shortname = '{{ Config::get("config.disqus_shortname") }}';
                            var disqus_identifier = '{{$image->id}}';

                            (function() {
                                var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                                dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                                (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                            })();
                        </script>
                        <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                        <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
                    </div>
                </div>


        {{--<div class="row">
            <div class="col-lg-12">
                <h2 class="title-between">Related images</h2>
            </div>
        </div>
        <div class="row">
            @for($i = 0; $i < 3; $i++)
                @include('tricks.card', [ 'test' => $i ])
            @endfor
        </div>--}}

    </div>
@stop
