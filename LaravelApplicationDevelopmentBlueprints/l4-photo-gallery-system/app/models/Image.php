<?php

class Image extends Eloquent {
  
  protected $table = 'images';

  protected $fillable = array(
    'album_id',
    'image',
    'description'
  );

  public $timestamps = true;
}
