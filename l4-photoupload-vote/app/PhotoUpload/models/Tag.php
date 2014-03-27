<?php namespace PhotoUpload\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'tags';

  /**
   * Fillable fields on DB 
   * 
   * @var mixed
   */
  protected $fillable = [
    'name',
    'slug',
    'user_id',
  ];

  /**
   * Query the imagesa that belong to the tag.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function images()
  {
    return $this->belongsToMany('\PhotoUpload\Models\Image');
  }
}
