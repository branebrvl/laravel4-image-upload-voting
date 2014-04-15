@extends('layouts.main');

@section('title', 'Render')

@section('scripts')
	<script type="text/javascript" src="{{url('js/selectize/js/standalone/selectize.min.js')}}"></script>
	<script src="http://d1n0x3qji82z53.cloudfront.net/src-min-noconflict/ace.js"></script>
	<script type="text/javascript" src="{{ asset('js/trick-new-edit.min.js') }}"></script>
@stop

@section('content')
<section class="page-wrap">
	<div class="container">
		<div class="row">
			<div class="page-md-center">
				<div class="content-box">
					@if(Auth::check() && (Auth::user()->id == $image->user_id))
						<div class="pull-right">
							<a class="btn btn-primary" data-toggle="modal" href="#deleteModal">Delete</a>
							@include('render.delete',['link'=>$image->deleteLink])
						</div>
					@endif
					<h2>
						Editing render 
					</h2>
					@if(Session::get('errors'))
					    <div class="alert alert-danger alert-dismissable">
					        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					         <h5>There were errors while editing this render:</h5>
					         @foreach($errors->all('<li>:message</li>') as $message)
					            {{$message}}
					         @endforeach
					    </div>
					@endif
					@if(Session::has('success'))
					    <div class="alert alert-success alert-dismissable">
					        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					         <h5>{{ Session::get('success') }}</h5>
					    </div>
					@endif
					{{ Form::open(array('class'=>'form-vertical','id'=>'save-image-form','role'=>'form'))}}
					    <div class="form-group">
					    	<label for="title">Title</label>
					    	{{Form::text('title', $image->title, array('class'=>'form-control','placeholder'=>'Name this image'));}}
					    </div>
					    <div class="form-group">
					    	<label for="description">Description</label>
					    	{{Form::textarea('description',$image->description, array('class'=>'form-control','placeholder'=>'Give detailed description of the image','rows'=>'3'));}}
					    </div>
					    <div class="form-group">
              <img src="{{$image->img_big}}" class="thumbnail">
					    </div>
					    <div class="form-group">
					    	{{ Form::select('tags[]', $tagList, $selectedTags, array('multiple','id'=>'tags','placeholder'=>'Tag this image','class' => 'form-control')); }}
					    </div>
					    <div class="form-group">
					        <div class="text-right">
					          <button type="submit"  id="save-section" class="btn btn-primary" data-style="expand-right">
					            Update Trick
					          </button>
					        </div>
					    </div>
					{{Form::close()}}
				</div>
			</div>
		</div>
	</div>
</section>
@stop
