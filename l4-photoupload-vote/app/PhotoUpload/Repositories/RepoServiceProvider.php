<?php namespace PhotoUpload\Repositories;

use Illuminate\Support\ServiceProvider;
use PhotoUpload\Repositories\Image\EloquentImageRepository;
use PhotoUpload\Models\Image;

class RepoServiceProvider extends ServiceProvider {

  public function register()
  {
    $this->app->bind('PhotoUpload\Repositories\Image\ImageRepositoryInterface', function()
    {
       return new EloquentImageRepository(new Image);
    });
  }
}
