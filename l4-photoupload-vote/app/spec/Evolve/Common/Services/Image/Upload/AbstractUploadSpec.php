<?php namespace spec\Evolve\Common\Services\Image\Upload;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use \Mockery as m;

class AbstractUploadSpec extends ObjectBehavior
{

 public static $functions;

  function let(
    \Evolve\Common\Services\Image\Manipulation\Intervention\ImageManip $imageManip,
    \Illuminate\Filesystem\Filesystem  $filesystem,
    \Illuminate\Config\Repository $config,
    \Evolve\Common\Utilities\Helpers $helpers 
  ){
    $this->beConstructedWith($imageManip, $filesystem, $config, $helpers);
  }

  function letgo()
  {
    // m::close();
  }

  function it_is_initializable()
  {
    $this->shouldHaveType('Evolve\Common\Services\Image\Upload\AbstractUpload');
  }

  function it_should_return_full_path(\Evolve\Common\Utilities\Helpers $helpers)
  {
    $helpers->getPublicPath()->willReturn('path');
    $this->getFullPath('where')->shouldReturn('path/where');
  }

  function it_should_create_an_image(
    UploadedFile $image,
    \Illuminate\Filesystem\Filesystem  $filesystem,
    \Evolve\Common\Services\Image\Manipulation\Intervention\ImageManip $imageManip,
    \Evolve\Common\Utilities\Helpers $helpers
  ) {
    $this->setSize(100);
    $this->setPath('where');

    $helpers->getRandomName()->willReturn('namer');

    $image->getRealPath()->willReturn('realpath');

    $imageManip->make('realpath')->willReturn($imageManip);
    $imageManip->resize(100,100)->willReturn($imageManip);
    $imageManip->save('where/namer.jpg', 65)->shouldBeCalled();
    $imageManip->succeeds()->willReturn(true);

    // $image = m::mock('\Symfony\Component\HttpFoundation\File\UploadedFile')
    //         ->shouldReceive('getRealPath')
    //         ->once()
    //         ->andReturn('realpath')
    //         ->shouldReceive('getMimeType')
    //         ->once()
    //         ->andReturn('image')
    //         ->getMock();

    $image->getMimeType()->willReturn('image');

    $filesystem->size('where/namer.jpg')->willReturn(100);

    $this->handle($image);
    $this->getJsonBody()->shouldReturn([
      'images' => [
        'filename' => 'namer.jpg',
        'mime' => 'image',
        'size' => 100,
        'path' => 'where/namer.jpg'
      ]
    ]);
  }
}

// https://github.com/phpspec/prophecy/pull/98
// there is known bug with phpspec and symfony UploadedFile class
// mockery is to slow to mock the same class, so I'm using this workaround
class UploadedFile
{
    public function getRealPath() {}
    public function getMimeType() {}
}
