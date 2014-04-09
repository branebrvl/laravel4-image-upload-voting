<?php namespace PhotoUpload\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Image extends Model {

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'images';

  /**
   * The class used to present the model.
   *
   * @var string
   */
  public $presenter = '\PhotoUpload\Presenters\ImagePresenter';

  /**
   * The relations to eager load on every query.
   *
   * @var array
   */
  protected $with = [ 'tags', 'user' ];

  /**
   * Fillable fields on database
   * 
   * @var mixed
   */
  protected $fillable = [
    'user_id',
    'title',
    'slug',
    'description',
    'img_min',
    'img_big',
    'ip',
    'view_cache',
    'show'
  ];

  /**
  * We set clients ip here
  *
  * @var array
  */
  // public function setIpAttribute($data){
  //   $this->attributes['ip'] = \Illuminate\Http\Request::getClientIp();
  // }
  /**
   * Hash the password
   * 
   * @param mixed $pass pass 
   * 
   * @return void
   */
  public function setTitleAttribute($data){

    $this->attributes['title'] = e($data);

  }

  /**
   * Convert the title to slug.
   * 
   * @param mixed $pass pass 
   * 
   * @return void
   */
  public function setSlugAttribute($data){

    $this->attributes['slug'] = Str::slug($data, '-');

  }

  /**
   * Create HTML enities desc.
   * 
   * @param mixed $pass pass 
   * 
   * @return void
   */
  public function setDescriptionAttribute($data){

    $this->attributes['description'] = e($data);

  }

  /**
   * Query the user that posted the image.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo('\PhotoUpload\Models\User');
  }

  /**
   * Query the tags under which the image was posted.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function tags()
  {
    return $this->belongsToMany('\PhotoUpload\Models\Tag');
  }
  
  /**
   * Query the images' votes.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function votes() 
  {
    return $this->belongsToMany('\PhotoUpload\Models\User','votes')
                ->withPivot('vote', 'notification')
                ->withTimestamps();
  }
}
