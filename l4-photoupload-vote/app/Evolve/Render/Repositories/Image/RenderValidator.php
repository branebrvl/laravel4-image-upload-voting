<?php namespace Evolve\Render\Repositories\Image;

use Evolve\Common\Validation\AbstractValidator;
use Evolve\Common\Validation\ValidationInterface;

/**
 * ImageUploadValidator 
 * 
 * @uses AbstractValidator
 * @uses ValidationInterface
 * @author Branislav Vladisavljev 
 */
class RenderValidator extends AbstractValidator implements ValidationInterface
{
  protected $rules = [
    'title' => 'required|min:4|unique:images,title',
    'description' => 'required|min:10',
    'tags' => 'required',
  ];
}
