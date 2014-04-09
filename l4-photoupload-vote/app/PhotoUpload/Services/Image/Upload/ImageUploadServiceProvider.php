<?php namespace PhotoUpload\Services\Image\Upload;
                               
use Illuminate\Support\ServiceProvider;
use PhotoUpload\Services\Image\Upload\Avatar\AvatarUpload;
use PhotoUpload\Services\Image\Upload\Render\RenderUpload;
use PhotoUpload\Services\Image\Upload\Render\RenderThumbUpload;
use PhotoUpload\Utilities\Helpers;

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
        return new AvatarUpload(
          new ImageManip(new ImageInt), 
          $app->files, 
          $app->config,
          new Helpers
        );
      });
      
      $this->app->bind('PhotoUpload\Services\Image\Upload\Render\RenderUpload', function($app)
      {
         return new RenderUpload($app->files, $app->config);
      });

      $this->app->bind('PhotoUpload\Services\Image\Upload\Render\RenderThumbUpload', function($app)
      {
        return new RenderThumbUpload(
          new ImageManip(new ImageInt), 
          $app->files, 
          $app->config,
          new Helpers
        );
      });
    }
} 
