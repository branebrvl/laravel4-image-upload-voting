<?php namespace Evolve\Render\Repositories\Tag;

use Evolve\Common\Validation\AbstractValidator;
use Evolve\Common\Validation\ValidationInterface;

/**
 * TagUploadValidator 
 * 
 */
class TagValidator extends AbstractValidator implements ValidationInterface
{
  protected $rules = [
    'name' => 'required'
  ];
}
