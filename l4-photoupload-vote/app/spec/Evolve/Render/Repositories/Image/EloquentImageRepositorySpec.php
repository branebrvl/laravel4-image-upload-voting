<?php

namespace spec\Evolve\Render\Repositories\Image;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\Repository as Config;
use Evolve\Render\Services\Image\Upload\Render\RenderThumbUpload;

class EloquentImageRepositorySpec extends ObjectBehavior
{
  function let(
    \Evolve\Render\Models\Image $model,
    Filesystem $filesystem,
    Config $config,
    RenderThumbUpload $renderThumbUpload
  ) {
    $this->beConstructedWith($model, $filesystem, $config, $renderThumbUpload);
  }
    
  function it_is_initializable()
  {
      $this->shouldHaveType('Evolve\Render\Repositories\Image\EloquentImageRepository');
  }
}
