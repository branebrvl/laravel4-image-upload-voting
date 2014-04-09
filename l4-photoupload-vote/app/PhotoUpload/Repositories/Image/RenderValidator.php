<?php namespace PhotoUpload\Repositories\Image;

use PhotoUpload\Validation\AbstractValidator;
use PhotoUpload\Validation\ValidationInterface;

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
