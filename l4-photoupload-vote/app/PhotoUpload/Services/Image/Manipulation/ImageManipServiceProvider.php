<?php namespace PhotoUpload\Services\Image\Manipulation;
                               
use Illuminate\Support\ServiceProvider;
use Intervention\Image\Image;
use PhotoUpload\Services\Image\Manipulation\Intervention\ImageManip;

class ImageManipServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void            
     */
    public function register() 
    {
      $this->app->bind( 'PhotoUpload\Services\Image\Manipulation\ImageManipInterface', function($app)
      {
         return new ImageManip(new Image);
      });
    }
} 
