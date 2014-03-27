<?php namespace PhotoUpload\Repositories;

use Illuminate\Support\ServiceProvider;
use PhotoUpload\Repositories\Image\EloquentImageRepository;
use PhotoUpload\Repositories\User\EloquentUserRepository;
use PhotoUpload\Repositories\Tag\EloquentTagRepository;
use PhotoUpload\Models\User;
use PhotoUpload\Models\Tag;
use PhotoUpload\Models\Image;

class RepoServiceProvider extends ServiceProvider {

  /**
   * register the service provider
   * 
   * 
   * @return void
   */
  public function register()
  {
    // dd($this->app);
    $this->app->bind('PhotoUpload\Repositories\Image\ImageRepositoryInterface', function($app)
    {
       return new EloquentImageRepository(new Image);
    });

    $this->app->bind('PhotoUpload\Repositories\User\UserRepositoryInterface', function()
    {
       return new EloquentUserRepository(new User);
    });

    $this->app->bind('PhotoUpload\Repositories\User\TagRepositoryInterface', function($app)
    {
       return new EloquentTagRepository(new Tag);
    });
  }
}
