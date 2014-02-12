<?php

class Album extends Eloquent {
  
  protected $table = 'albums';
  
  protected $fillable = array(
    'name',
    'description',
    'cover_image'
  );

  public $timestamps = true;

  public function photos() {
    return $this->hasMany('Image','album_id');
  }
}
