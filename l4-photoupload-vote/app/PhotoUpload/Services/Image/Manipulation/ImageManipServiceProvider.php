<?php namespace PhotoUpload\Service\Image\Manipulation;
                               
use Illuminate\Support\ServiceProvider;
use Intervention\Image\Facades\Image;
use PhotoUpload\Service\Image\Manipulation\ImageManip;

class ImageManipServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void            
     */
    public function register() 
    {
      $this->app->bind( 'PhotoUpload\Service\Image\Manipulation\ImageManipInterface', function()
      {
         return new ImageManip(new Image);
      });
    }
} 
