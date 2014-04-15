@extends('layouts.main')

@section('title','Search results for "'.$term.'"')

@section('scripts')
<script type="text/javascript">
$(function(){var s=$('.search-box');var t=s.val();s.focus().val('').val(t);});
</script>
@stop

@section('content')
  <section class="browse-recent">
    <div class="container">
		@if($term != '')
		<h2 class="page-title">{{ $images->getTotal(); }} Search {{Str::plural('result', count($images));}} for &quot;<strong>{{{$term}}}</strong>&quot;</h2>

		@include('render.grid', ['images' => $images, 'appends' => [ 'q' => $term ]])

		@else
			<h2>Please provide a search term</h2>
		@endif
    </div><!-- / .container -->
  </section><!-- / .browse-recent -->
@stop
