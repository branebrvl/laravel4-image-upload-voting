<?php namespace Evolve\Render;
                               
use Illuminate\Support\ServiceProvider;

/**
 * RenderServiceProvider 
 * 
 * @uses ServiceProvider
 */
class RenderBootServiceProvider extends ServiceProvider {

  public function boot()
  {
    $app = $this->app;

    # bootstrpa app  events
    $this->bindViewImageHandlerEvent($app);

    #bootstrap app errors
    $this->bindAbstractNotFoundExceptionError($app);
    $this->bindNotFoundHttpExceptionError($app);
    $this->bindModelNotFoundExceptionError($app);
  }

  protected function bindViewImageHandlerEvent($app)
  {
    $app['events']->listen('image.view', '\Evolve\Render\Events\ViewImageHandler');
  }

  protected function bindAbstractNotFoundExceptionError($app)
  {
    $app->error(function(\Evolve\Common\Exceptions\AbstractNotFoundException $exception) use ($app)
    {
      $error = $exception->getMessage();
      $app->log->error($error);

      return $app->make('\Illuminate\Support\Facades\Response')
                 ->view('home.error', compact('error'), 404);
    });
  }

  protected function bindNotFoundHttpExceptionError($app)
  {
    $app->error(function(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $exception) use ($app)
    {
      $error = 'Page Not Found: ' . $app->request->url();;
      $app->log->error('NotFoundHttpException Route: ' . $app->request->url() );

      return $app->make('\Illuminate\Support\Facades\Response')
                 ->view('home.error', compact('error'), 404);
    });
  }

  protected function bindModelNotFoundExceptionError($app)
  {
    $app->error(function(\Illuminate\Database\Eloquent\ModelNotFoundException $exception) use ($app)
    {
      $error = $exception->getMessage();
      $app->log->error($error);

      return $app->make('\Illuminate\Support\Facades\Response')
                 ->view('home.error', compact('error'), 404);
    });
  }

  // This must be here because the class extends ServiceProviders
  public function register() 
  {
  }
} 
