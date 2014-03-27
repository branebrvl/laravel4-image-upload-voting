<?php namespace PhotoUpload\Service\Image\Upload;
                               
use Illuminate\Support\ServiceProvider;
use PhotoUpload\Services\Image\Upload\Avatar\AvatarUpload;

/**
 * ImageManipServiceProvider 
 * 
 * @uses ServiceProvider
 */
class ImageUploadServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void            
     */
    public function register() 
    {
      $this->app->bind('PhotoUpload\Services\Image\Upload\Avatar\AvatarUpload', function($app)
      {
         return new AvatarUpload($app->files, $app->config);
      });
    }
} 
