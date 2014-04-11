<?php namespace Evolve\Common\Controllers;

use Illuminate\Routing\Controller;

class WebController extends Controller
{
  function __construct()
  {
    $this->beforeFilter('csrf', [ 'on' => 'post' ]);
  }
}
