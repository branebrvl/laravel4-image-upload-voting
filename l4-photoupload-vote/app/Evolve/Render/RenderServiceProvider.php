<?php namespace Evolve\Render;
                               
use Illuminate\Support\ServiceProvider;
use Intervention\Image\Image as ImageIntervention;
use Evolve\Common\Controllers\Web\BaseController;
use Evolve\Common\Utilities\Helpers;
use Evolve\Common\Services\Image\Manipulation\Intervention;
use Evolve\Common\Services\Image\Manipulation\Intervention\ImageManip;
use Evolve\Common\Exceptions\AbstractNotFoundException;
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
class RenderServiceProvider extends ServiceProvider {

  public function boot()
  {
    $app = $this->app;

    # bootstrpa app  events
    $app['events']->listen('image.view', '\Evolve\Render\Events\ViewImageHandler');

    #bootstrap app errors
    $app->error(function(AbstractNotFoundException $exception) use ($app)
    {
      $error = $exception->getMessage();
      $app->log->error($error);

      return $app->make('\Illuminate\Support\Facades\Response')
                 ->view('home.error', compact('error'), 404);
    });

    $app->error(function(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $exception) use ($app)
    {
      $error = 'Page Not Found: ' . $app->request->url();;
      $app->log->error('NotFoundHttpException Route: ' . $app->request->url() );

      return $app->make('\Illuminate\Support\Facades\Response')
                 ->view('home.error', compact('error'), 404);
    });

    $app->error(function(\Illuminate\Database\Eloquent\ModelNotFoundException $exception) use ($app)
    {
      $error = $exception->getMessage();
      $app->log->error($error);

      return $app->make('\Illuminate\Support\Facades\Response')
                 ->view('home.error', compact('error'), 404);
    });
  }

  /**
   * Register the service provider.
   *
   * @return void            
   */
  public function register() 
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

    $this->app->bind('Evolve\Common\Controllers\Web\BaseController', function($app)
    {
      return new BaseController(
        $app->make('request'),
        $app->make('auth'),
        $app->make('redirect'),
        $app->make('view')
      );
    });

    $this->app->bind('Evolve\Render\Services\Image\Upload\Render\RenderUpload', function($app)
    {
      return new RenderUpload(
        new ImageManip(new ImageIntervention), 
        $app->files, 
        $app->config,
        new Helpers
      );
    });

    $this->app->bind('Evolve\Render\Services\Image\Upload\Render\RenderThumbUpload', function($app)
    {
      return new RenderThumbUpload(
        new ImageManip(new ImageIntervention), 
        $app->files, 
        $app->config,
        new Helpers
      );
    });

    $this->app->bind('Evolve\Render\Repositories\Image\ImageRepositoryInterface', function($app)
    {
      return new EloquentImageRepository(
        new Image, 
        $app->files, 
        $app->config, 
        $app->make('Evolve\Render\Services\Image\Upload\Render\RenderThumbUpload'));
    });

    $this->app->bind('Evolve\Render\Repositories\User\UserRepositoryInterface', function($app)
    {
       return new EloquentUserRepository(new User, $app->files, $app->config);
    });

    $this->app->bind('Evolve\Render\Repositories\Tag\TagRepositoryInterface', function($app)
    {
       return new EloquentTagRepository(new Tag);
    });

    $this->app['navigation.builder'] = $this->app->share(function ($app) {
      return new Builder($app['config'], $app['auth']);
    });
  }
} 
