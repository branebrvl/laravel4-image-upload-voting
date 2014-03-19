<div href="#" class="trick-card col-lg-4 col-md-6 col-sm-6 col-xs-12">
	<div class="trick-card-inner js-goto-trick" data-slug="{{ $trick->ip}}">
		<a class="trick-card-title" href="{{  $trick->id}}">
		<img src="{{{ $trick->img_init_big}}}" alt="">
		</a>
    <div class="trick-card-stats trick-card-by">by <b><a href="{{-- route('user.profile', $trick->user->username) --}}">{{-- $trick->user->username --}}</a></b></div>
    <div class="trick-card-stats clearfix">                                                                                         
      <div class="trick-card-timeago">Submitted {{-- $trick->timeago --}} {{-- $trick->categories --}}</div>                                
      <div class="trick-card-stat-block"><span class="fa fa-eye"></span> {{-- $trick->view_cache --}}</div>                               
      <div class="trick-card-stat-block text-center"><span class="fa fa-comment"></span> <a href="{{ url('image/'.$trick->slug.'#disqus_thread') }}" data-disqus-identifier="{{$trick->id}}" style="color: #777;">0</a></div>
      <div class="trick-card-stat-block text-right"><span class="fa fa-heart"></span> {{-- $trick->vote_cache --}}</div>
    </div>
	</div>
</div>

