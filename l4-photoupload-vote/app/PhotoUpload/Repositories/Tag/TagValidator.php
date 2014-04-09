<?php namespace PhotoUpload\Repositories\Tag;

use PhotoUpload\Validation\AbstractValidator;
use PhotoUpload\Validation\ValidationInterface;

/**
 * TagUploadValidator 
 * 
 * @uses AbstractValidator
 * @uses ValidationInterface
 */
class TagValidator extends AbstractValidator implements ValidationInterface
{
    protected $rules = [
      'name' => 'required'
    ];
}
