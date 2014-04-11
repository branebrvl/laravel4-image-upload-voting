<?php namespace Evolve\Common\Services\Image\Manipulation;

/**
 * ImageManipInterface 
 * 
 * 
 */
interface ImageManipInterface
{
  public function errors();
  public function succeeds();
  public function make($path);
  public function save($path, $quality);
  public function resize($width, $width);
}
