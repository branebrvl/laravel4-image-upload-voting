@extends('layouts.main')

@section('title','Profile')

@section('content')
<section class="browse-recent">
  <div class="container">
	@if(Session::has('first_use'))
	  <div class="alert alert-success alert-dismissable text-center">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<h4>Welcome to Render!</h4>
		<p>Explore Render, create and share some of your own!</p>
	  </div>
	@endif

	@if(Session::has('success'))
	    <div class="alert alert-success alert-dismissable">
	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	         <h5>{{ Session::get('success') }}</h5>
	    </div>
	@endif

	<div class="row">
		<div class="user-renders-title">
			<h2>My renders </h2>
		</div>
		<div class="user-renders-new text-right">
			<a href="{{ url('user/images/new')}}" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Create new</a>
		</div>
	</div>

	@include('render.grid', [ 'images' => $images ])
  </div><!-- / .container -->
</section><!-- / .browse-recent -->
@stop
