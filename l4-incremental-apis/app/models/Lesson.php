<?php

class Lesson extends \Eloquent {

  protected $table = 'lessons';

  protected $fillable = ['title', 'body'];

  public function tags()
  {
    return $this->belongsToMany('Tag');
  }
}
