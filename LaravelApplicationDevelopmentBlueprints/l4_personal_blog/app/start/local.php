<?php

// specify require-dev service providers, aliases are specifed in app/config/local/app.php
App::register( 'Clockwork\Support\Laravel\ClockworkServiceProvider' );
App::register( 'Way\Generators\GeneratorsServiceProvider' );

// console.log shortcat
function l($val)
{
  return Clockwork::info($val);
}

function start($name, $description)
{
  return Clockwork::startEvent($name, $description);
}

function stop($name)
{
  return Clockwork::endEvent($name);
}
