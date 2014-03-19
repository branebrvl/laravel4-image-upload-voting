<?php return [
	  
    'debug' => true,

    /*
    |--------------------------------------------------------------------------
    | Append environment service providers
    |--------------------------------------------------------------------------
    */

    'providers' => append_config(array(

        'Clockwork\Support\Laravel\ClockworkServiceProvider',
        'Way\Generators\GeneratorsServiceProvider',

    )),

    /*
    |--------------------------------------------------------------------------
    |  Append environment aliases
    |--------------------------------------------------------------------------
    */

    'aliases' => append_config(array(

        'Clockwork'       => 'Clockwork\Support\Laravel\Facade',

    )),

];
