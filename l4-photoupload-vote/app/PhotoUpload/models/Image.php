<?php namespace PhotoUpload\models;

class Image extends \Eloquent {
  protected $table = 'images';

  protected $guarded = 'id, show';

  public static $uploadRules = array(
      'image'=> 'required|image'
  );

  public function users() 
  {
    return $this->belongsToMany('\PhotoUpload\models\User','votes')->withPivot('vote', 'notification')->withTimestamps();
  }


}
