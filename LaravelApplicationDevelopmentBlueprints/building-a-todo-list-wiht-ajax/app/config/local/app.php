<?php return [
	  
    'debug' => true,

    'providers' => [
         'Clockwork\Support\Laravel\ClockworkServiceProvider',
         'Way\Generators\GeneratorsServiceProvider',
     ],

    'aliases' => ['Clockwork' => 'Clockwork\Support\Laravel\Facade'],
];
