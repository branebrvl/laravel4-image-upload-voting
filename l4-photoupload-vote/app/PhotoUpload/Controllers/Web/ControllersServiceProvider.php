<?php namespace PhotoUpload\Controllers\Web;

use Illuminate\Support\ServiceProvider;
use PhotoUpload\Controllers\Web\BaseController;

class ControllersServiceProvider extends ServiceProvider {

  /**
   * register the service provider
   * 
   * 
   * @return void
   */
  public function register()
  {
    // dd($this->app);
    $this->app->bind('PhotoUpload\Controllers\Web\BaseController', function($app)
    {
      return new BaseController(
        $app->make('request'),
        $app->make('auth'),
        $app->make('redirect'),
        $app->make('view')
      );
    });
  }
}
