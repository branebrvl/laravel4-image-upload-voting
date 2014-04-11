<?php namespace spec\Evolve\Render\Models;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImageSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Evolve\Render\Models\Image');
    }
}
