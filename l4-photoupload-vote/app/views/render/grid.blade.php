<div class="row">
  @if($images->count())
    @foreach($images as $image)
      @include('render.card', [ 'image' => $image ])
    @endforeach
  @else
    <div class="col-lg-12">
      <div class="alert alert-danger">
        Sorry, but I couldn't find any images for you!
      </div>
    </div>
  @endif
</div><!-- / .row -->
