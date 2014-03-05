<?php


class TasksController extends BaseController {
	
	
	public function index()
	{		
		$tasks = Task::with('user')->orderby('completed')->orderby('completed', 'desc')->orderby('created_at', 'desc')->get();
		$users = User::orderby('name')->lists('name', 'id');
		
		
		return View::make('tasks.index', compact('tasks', 'users'));	
	}
	
	
	public function store()
	{	
		$task = new Task(Input::all());
		
		
		if (!$task->save())
		{
			return Redirect::back()->withInput()->withErrors($task->getErrors());
		}
		
		
		return Redirect::home();
	}
	
	
	public function update($id)
	{	
		$task = Task::find($id);
		$task->completed = Input::get('completed') ? Input::get('completed') : 0;
		$task->save();
		
		
		return $task;
	}
	
	
	public function destroy()
	{	
		$task = Task::find(Input::get('task_id'));
		$task->delete();
		
		
		return $task;
	}
}