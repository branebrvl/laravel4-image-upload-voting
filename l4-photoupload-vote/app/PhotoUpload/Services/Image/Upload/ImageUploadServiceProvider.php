<?php namespace PhotoUpload\Service\Image\Upload;
                               
use Illuminate\Support\ServiceProvider;
use PhotoUpload\Services\Image\Upload\ImageUpload;

/**
 * ImageManipServiceProvider 
 * 
 * @uses ServiceProvider
 * @author Branislav Vladisavljev 
 */
class ImageManipServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void            
     */
    public function register() 
    {
      $this->app->bind('PhotoUpload\Services\Image\Upload\ImageUploadInterface', function($app)
      {
         return new ImageUpload($app->files, $app->config);
      });
    }
} 
