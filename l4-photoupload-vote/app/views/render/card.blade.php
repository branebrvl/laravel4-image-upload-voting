<div href="#" class="trick-card col-lg-4 col-md-6 col-sm-6 col-xs-12">
	<div class="trick-card-inner js-goto-trick" data-slug="{{ $image->slug }}">
		<a class="trick-card-title" href="{{ route('images.show', [ $image->slug ]) }}">
			{{{ $image->title }}}
		</a>
    {{-- <div class="trick-card-stats trick-card-by">by <b><a href="{{ route('user.profile', $image->user->username) }}">{{ $image->user->username }}</a></b></div> --}}
    {{HTML::image($image->img_min, 'render', ['id'=>'renderimg'])}}
		<div class="trick-card-stats clearfix">
			<div class="trick-card-timeago">Submitted {{ $image->timeago }} </div>
			<div class="trick-card-stat-block"><span class="fa fa-eye"></span> {{$image->view_cache}}</div>
			<div class="trick-card-stat-block text-center"><span class="fa fa-comment"></span> <a href="{{ url('images/'.$image->slug.'#disqus_thread') }}" data-disqus-identifier="{{$image->id}}" style="color: #777;">0</a></div>
			<div class="trick-card-stat-block text-right"><span class="fa fa-heart"></span> {{$image->vote_cache}}</div>
		</div>
		<div class="trick-card-tags clearfix">
			@foreach($image->tags as $tag)
			    <a href="{{url('tags/'.$tag->slug)}}" class="tag" title="{{$tag->name}}">{{$tag->name}}</a>
			@endforeach
		</div>
	</div>
</div>

