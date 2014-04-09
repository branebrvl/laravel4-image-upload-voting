<?php namespace PhotoUpload\Controllers\Web;

use Illuminate\Routing\Controller;

class WebController extends Controller
{
  function __construct()
  {
    $this->beforeFilter('csrf', [ 'on' => 'post' ]);
  }
}
