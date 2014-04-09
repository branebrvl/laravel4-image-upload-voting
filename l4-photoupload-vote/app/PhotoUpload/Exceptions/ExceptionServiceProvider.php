<?php namespace PhotoUpload\Exceptions;

use Illuminate\Support\ServiceProvider;

class ExceptionServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $app = $this->app;

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

    public function register() {}
}
