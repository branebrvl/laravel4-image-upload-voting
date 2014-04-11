<?php namespace Evolve\Render\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements UserInterface, RemindableInterface {
  /**
   * The class to used to present the model.
   *
   * @var string
   */
  public $presenter = 'Evolve\Render\Presenters\UserPresenter';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

  /**
   * Fillable fields on database
   * 
   * @var mixed
   */
  protected $fillable = [
    'email',
    'photo',
    'username',
    'password',
    'admin'
  ];

  /**
   * Hash the password
   * 
   * @param mixed $pass pass 
   * 
   * @return void
   */
  public function setPasswordAttribute($pass)
  {
    $this->attributes['password'] = Hash::make($pass);
  }

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

  /**
   * Get the e-mail address where password reminders are sent.
   *
   * @return string
   */
  public function getReminderEmail()
  {
    return $this->email;
  }

  /**
  * Users should not be admin by default
  *
  * @var array
  */
  protected $attributes = [
    'admin' => false
  ];

  /**
   * Check user's permissions
   *
   * @return bool
   */
  public function isAdmin()
  {
    return ($this->admin == true);
  }

  /**
   * Get the user's avatar image.
   *
   * @return string
   */
  public function getPhotocssAttribute()
  {
    if($this->photo) 
    {
      return url(\Config::get('image.avatar_folder') . '/' . $this->photo);
    }

    return \Gravatar::src($this->email, 100);
  }

  /**
   * Query the imagess that the user has posted.
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function images()
  {
    return $this->hasMany('\Evolve\Render\Models\Image');
  }

  /**
   * Query the votes that are casted by the user.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function votes()
  {
    return $this->belongsToMany('\Evolve\Render\Models\Image','votes')
                 ->withPivot('vote', 'notification')
                 ->withTimestamps();
  }
}
