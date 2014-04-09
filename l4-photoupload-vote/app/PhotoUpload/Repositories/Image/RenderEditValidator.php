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
      'title'         => 'required|min:4|unique:images,title',
      'description'   => 'required|min:10',
      'tags'          => 'required',  
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
