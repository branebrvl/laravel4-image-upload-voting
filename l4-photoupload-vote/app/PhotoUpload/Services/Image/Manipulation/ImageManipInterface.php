<?php namespace PhotoUpload\Services\Image\Manipulation;

/**
 * undocumented class
 *
 * @package default
 * @author Me
 */
interface ImageManipInterface
{
  public function errors();
  public function succeeds();
  public function make($path);
  public function save($path, $quality);
  public function resize($width, $width);
}
