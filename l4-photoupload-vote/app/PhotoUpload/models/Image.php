<?php namespace PhotoUpload\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model {

  protected $table = 'images';

  protected $guarded = ['id', 'show'];

  public function users() 
  {
    return $this->belongsToMany('\PhotoUpload\models\User','votes')->withPivot('vote', 'notification')->withTimestamps();
  }
}
