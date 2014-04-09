<?php namespace PhotoUpload\Repositories;

use Illuminate\Support\ServiceProvider;
use Intervention\Image\Image as ImageInt;
use PhotoUpload\Services\Image\Upload\Avatar\AvatarUpload;
use PhotoUpload\Services\Image\Manipulation\Intervention\ImageManip;
use PhotoUpload\Services\Image\Upload\Render\RenderThumbUpload;
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
      return new EloquentImageRepository(
        new Image, 
        $app->files, 
        $app->config, 
        $app->make('PhotoUpload\Services\Image\Upload\Render\RenderThumbUpload'));
    });

    $this->app->bind('PhotoUpload\Repositories\User\UserRepositoryInterface', function($app)
    {
       return new EloquentUserRepository(new User, $app->files, $app->config);
    });

    $this->app->bind('PhotoUpload\Repositories\Tag\TagRepositoryInterface', function($app)
    {
       return new EloquentTagRepository(new Tag);
    });
  }
}
