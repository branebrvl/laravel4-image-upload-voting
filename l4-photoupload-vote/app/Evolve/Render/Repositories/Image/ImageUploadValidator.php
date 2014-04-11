<?php namespace Evolve\Render\Repositories\Image;

use Evolve\Common\Validation\AbstractValidator;
use Evolve\Common\Validation\ValidationInterface;

/**
 * ImageUploadValidator 
 * 
 * @uses AbstractValidator
 * @uses ValidationInterface
 */
class ImageUploadValidator extends AbstractValidator implements ValidationInterface
{
  protected $rules = [
    'image' => 'required|image'
  ];
}
