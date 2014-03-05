<?php namespace PhotoUpload\Repositories;

use Illuminate\Support\ServiceProvider;
use PhotoUpload\Repositories\Image\DbImageRepository;
use PhotoUpload\models\Image;

class RepoServiceProvider extends ServiceProvider {

  public function register()
  {
    $this->app->bind('PhotoUpload\Repositories\Image\ImageRepositoryInterface', function()
    {
       return new DbImageRepository(new Image);
    });
  }
}
