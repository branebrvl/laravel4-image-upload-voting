<?php namespace PhotoUpload\Services\Image\Manipulation;

/**
 * undocumented class
 *
 * @package default
 * @author Me
 */
interface ImageManipInterface
{
  public function from($from);
  public function to($to);
  public function resize($width, $width);
}
