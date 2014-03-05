<?php

class Lesson extends \Eloquent {

  protected $table = 'lessons';

  protected $fillable = ['title', 'body'];
}
