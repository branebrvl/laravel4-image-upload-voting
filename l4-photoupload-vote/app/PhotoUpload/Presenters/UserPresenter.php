<?php namespace PhotoUpload\models\Presenters;

use PhotoUpload\models\User;
use McCool\LaravelAutoPresenter\BasePresenter;

class UserPresenter extends BasePresenter
{
  /**
   * Create a new UserPresenter instance.
   *
   * @param  \PhotoUpload\models\User  $user
   * @return void
   */
  public function __construct(User $user)
  {
    $this->resource = $user;
  }

  /**
   * Get the timestamp of the last posted image of this user.
   *
   * @param  \Illuminate\Pagination\Paginator  $images
   * @return string
   */
  public function lastActivity($images)
  {
    if (count($images) == 0) {
        return 'No activity';
    }

    $collection = $images->getCollection();
    $sorted = $collection->sortBy(function ($image) {
        return $image->created_at;
    })->reverse();

    $last = $sorted->first();

    return $last->created_at->diffForHumans();
  }

  /**
   * Get the full name of this user.
   *
   * @return string
   */
  public function fullName()
  {
    $profile = $this->resource->profile;

    if (! is_null($profile) && ! empty($profile->name)) {
        return $profile->name;
    }

    return $this->resource->username;
  }

  /**
   * Get the user's avatar image.
   *
   * @return string
   */
  public function getPhotocssAttribute()
  {
    if($this->photo) {
      return url('img/avatar/' . $this->photo);
    }

    return Gravatar::src($this->email, 100);
  }

}
