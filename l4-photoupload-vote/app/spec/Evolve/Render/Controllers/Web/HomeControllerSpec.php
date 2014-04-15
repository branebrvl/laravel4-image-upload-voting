<?php

namespace spec\Evolve\Render\Controllers\Web;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HomeControllerSpec extends ObjectBehavior
{

  function let(
   \Evolve\Render\Repositories\Image\ImageRepositoryInterface $image,
   \Evolve\Common\Controllers\BaseController $base 
  ) {
    $this->beConstructedWith($image, $base);
  }

  function it_is_initializable()
  {
    $this->shouldHaveType('\Evolve\Render\Controllers\Web\HomeController');
  }

  function it_uses_image_repo_to_get_all_paginated(
    \Evolve\Render\Repositories\Image\ImageRepositoryInterface $image
  ) {
    $image->getMostRecent()->shouldBeCalled();
    $this->getIndex();
    // $this->getIndex()->shouldReturnAnInstanceOf('\Illuminate\View\Environment');
  }

  function it_should_retrun_index_view(
   \Evolve\Common\Controllers\BaseController $base 
  ) {
    $images = [];

    $base->view('home.index', compact('images'))
          ->willReturn('view_response');

    $this->getIndex()->shouldReturn('view_response');
  }
}
