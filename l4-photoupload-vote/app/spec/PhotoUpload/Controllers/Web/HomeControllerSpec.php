<?php

namespace spec\PhotoUpload\Controllers\Web;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HomeControllerSpec extends ObjectBehavior
{

  function let(
   \PhotoUpload\Repositories\Image\ImageRepositoryInterface $image,
   \PhotoUpload\Controllers\Web\BaseController $base 
  ) {
    $this->beConstructedWith($image, $base);
  }

  function it_is_initializable()
  {
    $this->shouldHaveType('\PhotoUpload\Controllers\Web\HomeController');
  }

  function it_uses_image_repo_to_get_all_paginated(
    \PhotoUpload\Repositories\Image\ImageRepositoryInterface $image
  ) {
    $image->getAllPaginated()->shouldBeCalled();
    $this->getIndex();
    // $this->getIndex()->shouldReturnAnInstanceOf('\Illuminate\View\Environment');
  }

  function it_should_retrun_index_view(
   \PhotoUpload\Controllers\Web\BaseController $base 
  ) {
    $images = [];

    $base->view('home.index', compact('images'))
          ->willReturn('view_response');

    $this->getIndex()->shouldReturn('view_response');
  }
}
