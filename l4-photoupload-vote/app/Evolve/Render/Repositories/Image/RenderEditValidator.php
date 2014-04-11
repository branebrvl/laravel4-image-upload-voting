<?php namespace Evolve\Render\Repositories\Image;

use Evolve\Common\Validation\AbstractValidator;
use Evolve\Common\Validation\ValidationInterface;

/**
 * ImageUploadValidator 
 * 
 * @uses AbstractValidator
 */
class RenderEditValidator extends AbstractValidator implements ValidationInterface
{
  /**
   * The id of the image.
   *  
   * @var mixed
   */
  protected $id;
    
  /**
   * The validation rules to validate the input data against.
   *
   * @var array
   */
  protected $rules = [
    'title' => 'required|min:4|unique:images,title',
    'description' => 'required|min:10',
    'tags' => 'required',  
  ];

  /**
   * Get the prepared validation rules.
   *    
   * @return array
   */   
  protected function getPreparedRules()
  {     
    $this->rules['title'] .= ',' . $this->id;
    
    return $this->rules;
  }
}
