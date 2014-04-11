<?php namespace Evolve\Render\Presenters;

use Evolve\Render\Models\User;
use McCool\LaravelAutoPresenter\BasePresenter;

class UserPresenter extends BasePresenter
{

  /**
   * Create a new UserPresenter instance.
   *
   * @param  \Evolve\Render\Models\User  $user
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
    if (count($images) == 0) 
    {
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

    if (! is_null($profile) && ! empty($profile->name))
    {
      return $profile->name;
    }

    return $this->resource->username;
  }

  /**
   * Get boolean represenation of blocked_at column.
   * 
   * 
   * @return string
   */
  public function blockedAt()
  {
    if(is_null($this->resource->blocked_at))
    {
      return 0;
    }

    return 1;
  }

}
