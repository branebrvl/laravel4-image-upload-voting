<?php namespace PhotoUpload\Events;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
  public function boot()
  {
    $this->app['events']->listen('image.view', '\PhotoUpload\Events\ViewImageHandler');
  }

  public function register()
  {

  }
}
