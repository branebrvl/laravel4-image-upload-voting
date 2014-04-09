<?php

namespace spec\PhotoUpload\Controllers\Web;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BaseControllerSpec extends ObjectBehavior
{


  function let(
      \Illuminate\Http\Request $request,
      \Illuminate\Auth\AuthManager $auth,
      \Illuminate\Routing\Redirector $redirect,
      \Illuminate\View\Environment $view
  ) {
     $request->beADoubleOf('\Illuminate\Http\Request');
     $auth->beADoubleOf('\Illuminate\Auth\AuthManager');
     $redirect->beADoubleOf('\Illuminate\Routing\Redirector');
     $view->beADoubleOf('\Illuminate\View\Environment');

     $this->beConstructedWith($request, $auth, $redirect, $view);
  }

  function it_is_initializable()
  {
    $this->shouldHaveType('\PhotoUpload\Controllers\Web\BaseController');
  }

  function it_should_set_a_view(\Illuminate\View\Environment $view)
  {
    $view->make('layout', [])
          ->willReturn('view')
          ->shouldBeCalled();

    $this->view('layout', [])
          ->shouldReturn('view');
          // ->shouldReturnAnInstanceOf('Illuminate\View\View');
  }
}
