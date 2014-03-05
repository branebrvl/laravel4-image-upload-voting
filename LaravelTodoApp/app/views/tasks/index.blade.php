@extends('layouts.master')


@section('content')
<div class="col-md-6">
	<h1>All Tasks</h1>
		
	<ul class="list-group">
		@foreach ($tasks as $task)
			<li class="list-group-item {{ $task->completed ? 'completed' : '' }}">
				{{ Form::model($task, ['class' => 'task-update-form', 'method' => 'PATCH', 'route' => ['tasks.update', $task->id]]) }}
					{{ Form::checkbox('completed') }}
				{{ Form::close() }}

				<img src="{{ gravatar_url($task->user->email) }}" alt="{{ $task->user->username }}" />
				<strong>{{ $task->title }}</strong>
							
				{{ link_to(null, 'Delete', ['class' => 'task-delete btn btn-xs btn-danger', 'data-task-id' => $task->id]) }}
			</li>
		@endforeach
	</ul>
</div>

<div class="col-md-6">
	<h3>Add New Task</h3>
	@include('tasks/partials/_form')
</div>
@stop