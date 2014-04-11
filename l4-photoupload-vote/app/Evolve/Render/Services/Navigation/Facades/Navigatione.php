<?php namespace Evolve\Render\Services\Navigation\Facades;

use Illuminate\Support\Facades\Facade;

class Navigatione extends Facade
{
  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor()
  {
    return 'navigation.builder';
  }
}
