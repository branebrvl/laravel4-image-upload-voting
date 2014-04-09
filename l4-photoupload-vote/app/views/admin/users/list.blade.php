@extends('layouts.main')

@section('title','Viewing users')

@section('scripts')
<script>
  (function ($) {
     $(".js-block-user").click(function (t) {
         t.preventDefault();
         var n = $(this).attr("data-blocked") == "0";
         var r = {
             _token: "{{ csrf_token() }}",
             id:$(this).attr("rel")
         };
        var self = this;

         $.post('http://render/admin/users/block', r, function (t) {
             if (t != "error") {
                 if (!n) {
                     $(self).attr("data-blocked", "0");
                     $(self).html("Block")
                 } else {
                     $(self).attr("data-blocked", "1");
                     $(self).html("Unblock")
                 }

             }else {
             }
         })
     })
		// Populate the field with the right data for the modal when clicked
		$('.delete_toggler').each(function(index,elem) {
		    $(elem).click(function(e){
		    	e.preventDefault();
		    	var href = "{{url('admin/users/delete')}}/";
				$('#delete_link').attr('href',href + $(elem).attr('rel'));
				$('#delete_tag').modal('show');
		    });
		});
		@if($errors->all())
		$('#add_tag').modal('show');
		@endif
  })(jQuery)  
</script>
@stop

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-12">
       		@if(Session::has('user_created'))
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              Your invite has been sent!
            </div>
       		@endif
			<div class="page-header">
			  <h1>Showing all users ({{ $users->getTotal() }})<span class="pull-right"><a data-toggle="modal" href="#add_tag" class="btn btn-primary btn-lg">Add new User</a></span></h1>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<table class="table">
			   	<thead>
			    	<tr>
				     	<th>Avatar</th>
						<th>Username</th>
						<th>Email</th>
						<th>Renders</th>
						<th>Date Registered</th>
						<th>Actions</th>
			    	</tr>
			   	</thead>
			   	<tbody>
				  	@foreach($users as $user)
				    <tr>
				    	<td><img src="{{ $user->photocss }}" class="img-rounded" style="width:40px; height:40px;"></td>
				        <td><a href="{{url($user->username)}}" target="_blank">{{$user->username}}</a></td>
				       	<td>{{$user->email}}</td>
				       	<td>{{count($user->images)}}</td>
				       	<td>{{$user->created_at}}</td>
                <td>
                  <div class="btn-group pull-right">
                    <a class="btn btn-primary btn-sm js-block-user @if($user->blockedAt) text-primary @endif" data-blocked="{{$user->blockedAt}}"  rel="{{$user->id}}">
                    <span class="js-block-status">
                        @if($user->blockedAt)
                            Unblock
                        @else
                            Block
                        @endif
                    </span>
                    </a> 
                    <a class="delete_toggler btn btn-danger btn-sm" rel="{{$user->id}}">Delete</a>
                  </div>
                </td>
				     </tr>
				    @endforeach
			    </tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="text-center">{{ $users->links(); }}</div>
		</div>
	</div>
</div>

<!-- Modal -->
 <div class="modal fade" id="add_tag" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
         <h4 class="modal-title">Adding new User</h4>
       </div>
       <div class="modal-body">
       		@if($errors->all())
       		    <div class="bs-callout bs-callout-danger">
       		        <h4>Please fix the errors below:</h4>
       		        {{ HTML::ul($errors->all())}}
       		    </div>
       		@endif

        {{ Form::open(['url' => 'admin/users/invite', 'method' => 'post']) }}
            <div class="form-group">
                {{ Form::label('username', 'Username', [ 'class' => 'control-label' ]) }}
                {{ Form::text('username', null, ['class'=>'form-control', 'placeholder' => 'Username'])}}
            </div>
            <div class="form-group">
                {{ Form::label('email', 'Email', [ 'class' => 'control-label' ]) }}
                {{ Form::text('email', null, ['class'=>'form-control', 'placeholder' => 'E-mail to send invitation...'])}}
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block btn-login">Send Invitation</button>
            </div>
        {{ Form::close() }}
       </div>
     </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
 </div><!-- /.modal -->

<!-- Modal -->
 <div class="modal fade" id="delete_tag" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
         <h4 class="modal-title">Are you sure?</h4>
       </div>
       <div class="modal-body">
        	<p class="lead text-center">This User will be deleted!</p>
       </div>
       <div class="modal-footer">
        	<a data-dismiss="modal" href="#delete_tag" class="btn btn-default">Keep</a>
        	<a href="" id="delete_link" class="btn btn-danger">Delete</a>
       </div>
     </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
 </div><!-- /.modal -->
@stop
