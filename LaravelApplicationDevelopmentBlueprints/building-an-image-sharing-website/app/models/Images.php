<?php

class Images extends Eloquent
{
  protected $table = 'images';

  protected $fillable = array('title', 'image');

  public static $upload_rules = array(
      'title'=> 'required|min:3',
      'image'=> 'required|image'
  );

  public $timestamps = true;
}
