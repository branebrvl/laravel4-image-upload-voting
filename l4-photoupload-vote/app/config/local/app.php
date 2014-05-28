<?php return [
	  
    'debug' => true,

    /*
    |--------------------------------------------------------------------------
    | Append environment service providers
    |--------------------------------------------------------------------------
    */

    'providers' => append_config([
      'Clockwork\Support\Laravel\ClockworkServiceProvider',
      'Way\Generators\GeneratorsServiceProvider',
    ]),

    /*
    |--------------------------------------------------------------------------
    |  Append environment aliases
    |--------------------------------------------------------------------------
    */

    'aliases' => append_config([
      'Clockwork' => 'Clockwork\Support\Laravel\Facade',
    ]),

];
