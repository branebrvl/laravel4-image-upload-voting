<article class="render-card">
  <div class="render-shot">
    <div class="render-img">
      <a href="{{ route('images.show', [ $image->slug ]) }}" class="render-link"><img src="{{ $image->img_min  }}" alt=""></a>
    </div><!-- render-img -->
    <ul class="render-tools">
      <li class="fav"><span>{{$image->vote_cache}}</span></li>
      <li class="views"><span> {{$image->view_cache}}</span></li>
    </ul><!-- / .render-tools -->
  </div><!-- / .render-shot -->
  <div class="render-user">
    <a href="{{ route('user.profile', $image->user->username) }}"><img class="render-user-img" src="{{$image->user->photocss}}" alt=""></a>
    <a href="{{ route('user.profile', $image->user->username) }}"><span class="render-user-link">{{ $image->user->username }}</span></a>
  </div><!-- / .render-user -->
</article><!-- / .render -->
