<div class="row js-image-container">
	@if($images->count())
		@foreach($images as $image)
			@include('tricks.card', [ 'image' => $image ])
		@endforeach
	@else
		<div class="col-lg-12">
			<div class="alert alert-danger">
				Sorry, but I couldn't find any images for you!
			</div>
		</div>
	@endif
</div>
@if($images->count())
	<div class="row">
	    <div class="col-md-12 text-center">
	    	@if(isset($appends))
	        	{{ $images->appends($appends)->links(); }}
	        @else
				{{ $images->links(); }}
	        @endif
	    </div>
	</div>
@endif

@section('scripts')
	@if(count($images))
		<script src="{{ asset('js/vendor/masonry.pkgd.min.js') }}"></script>
		<script>
$(function(){$container=$(".js-trick-container");$container.masonry({gutter:0,itemSelector:".trick-card",columnWidth:".trick-card"});$(".js-goto-trick a").click(function(e){e.stopPropagation()});$(".js-goto-trick").click(function(e){e.preventDefault();var t="{{ route('images.show') }}";var n=$(this).data("slug");window.location=t+"/"+n})})
		</script>
	@endif
@stop
