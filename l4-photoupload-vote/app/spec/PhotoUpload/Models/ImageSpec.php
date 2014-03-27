<?php namespace spec\PhotoUpload\Models;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImageSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('PhotoUpload\Models\Image');
    }
}
