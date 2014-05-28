<?php namespace Evolve\Render;
                               
use Illuminate\Support\ServiceProvider;
use Intervention\Image\Image as ImageIntervention;
use Evolve\Common\Controllers\Web\BaseController;
use Evolve\Common\Utilities\Helpers;
use Evolve\Common\Services\Image\Manipulation\Intervention;
use Evolve\Common\Services\Image\Manipulation\Intervention\ImageManip;
use Evolve\Render\Services\Image\Upload\Render\RenderUpload;
use Evolve\Render\Services\Image\Upload\Render\RenderThumbUpload;
use Evolve\Render\Repositories\Image\EloquentImageRepository;
use Evolve\Render\Repositories\User\EloquentUserRepository;
use Evolve\Render\Repositories\Tag\EloquentTagRepository;
use Evolve\Render\Models\User;
use Evolve\Render\Models\Tag;
use Evolve\Render\Models\Image;
use Evolve\Render\Services\Navigation\Builder;
use Evolve\Render\Services\Image\Upload\Avatar\AvatarUpload;

/**
 * RenderServiceProvider 
 * 
 * @uses ServiceProvider
 */
class RenderRegisterServiceProvider extends ServiceProvider {

  /**
   * Register service providears.
   *
   * @return void            
   */
  public function register() 
  {
    $this->registerAvatarUploadService();
    $this->registerBaseController();
    $this->registerRenderUploadService();
    $this->registerThumbUploadService();
    $this->registerImageRepository();
    $this->registerUserRepository();
    $this->registerTagRepository();

    $this->app['navigation.builder'] = $this->app->share(function ($app) {
      return new Builder($app['config'], $app['auth']);
    });
  }

  protected function registerAvatarUploadService()
  {
    $this->app->bind('Evolve\Render\Services\Image\Upload\Avatar\AvatarUpload', function($app)
    {
      return new AvatarUpload(
        new ImageManip(new ImageIntervention), 
        $app->files, 
        $app->config,
        new Helpers
      );
    });
  }

  protected function registerBaseController()
  {
    $this->app->bind('Evolve\Common\Controllers\Web\BaseController', function($app)
    {
      return new BaseController(
        $app->make('request'),
        $app->make('auth'),
        $app->make('redirect'),
        $app->make('view')
      );
    });
  }

  protected function registerRenderUploadService()
  {
    $this->app->bind('Evolve\Render\Services\Image\Upload\Render\RenderUpload', function($app)
    {
      return new RenderUpload(
        new ImageManip(new ImageIntervention), 
        $app->files, 
        $app->config,
        new Helpers
      );
    });
  }

  protected function registerThumbUploadService()
  {
    $this->app->bind('Evolve\Render\Services\Image\Upload\Render\RenderThumbUpload', function($app)
    {
      return new RenderThumbUpload(
        new ImageManip(new ImageIntervention), 
        $app->files, 
        $app->config,
        new Helpers
      );
    });
  }

  protected function registerImageRepository()
  {
    $this->app->bind('Evolve\Render\Repositories\Image\ImageRepositoryInterface', function($app)
    {
      return new EloquentImageRepository(
        new Image, 
        $app->files, 
        $app->config, 
        $app->make('Evolve\Render\Services\Image\Upload\Render\RenderThumbUpload'));
    });
  }

  protected function registerUserRepository()
  {
    $this->app->bind('Evolve\Render\Repositories\User\UserRepositoryInterface', function($app)
    {
       return new EloquentUserRepository(new User, $app->files, $app->config);
    });
  }

  protected function registerTagRepository()
  {
    $this->app->bind('Evolve\Render\Repositories\Tag\TagRepositoryInterface', function($app)
    {
       return new EloquentTagRepository(new Tag);
    });
  }
} 
