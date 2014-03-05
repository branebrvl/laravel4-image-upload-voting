<?php


class Task extends BaseModel {

	protected $guarded = ['id'];
	
	
	protected $softDelete = true;
	
	
	protected static $rules = [
		'title' => 'required'
	];
	
	
	public function user()
	{
		return $this->belongsTo('User');
	}
	
	
	public static function find($id, $username = null)
	{
		$task = static::with('user')->find($id);
		
		if ($username and $task->user->username !== $username)
			throw new Illuminate\Database\Eloquent\ModelNotFoundException;
			
		return $task;
	}
}