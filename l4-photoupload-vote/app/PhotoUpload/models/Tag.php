<?php namespace PhotoUpload\Models;

use Illuminate\Support\Str;
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
   * Convert names to slug.
   * 
   * @param mixed $pass pass 
   * 
   * @return void
   */
  public function setSlugAttribute($data){

    $this->attributes['slug'] = Str::slug($data, '-');

  }

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
