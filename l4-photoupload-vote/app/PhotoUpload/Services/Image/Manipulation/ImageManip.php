<?php namespace PhotoUpload\Services\Image\Manipulation;

use Intervention\Image\Facades\Image;
/**
 * 
 */
class ImageManip implements ImageManipInterface
{

  protected $image;

  protected $errors = []; 

  protected $succeeds = false;


  public function __construct(Image $image)
  {
    $this->image = $image; 
  }

  /**
   * Return the errors if any
   *
   * @return array           
   */
  final public function errors()  
  {
      return $this->errors;  
  }

  final public function succeeds()  
  {
      return $this->succeeds;  
  }

  public function make($path)
  {
    $this->image->make($path);

    return $this;
  }

  public function save($path)
  {
    $this->image->save($path);

    return $this;
  }

  public function resize($width, $height)
  {
    try
    {
      $this->image->resize($width, $height, true);
      $this->succeeds = true;
    } 

    catch (Exception $e)
    {
      // Log::error('[IMAGE SERVICE] Failed to resize image: [' . $e->getMessage() . ']');
      $this->errors ='[IMAGE SERVICE] Failed to resize image: [' . $e->getMessage() . ']';  
      $this->succeeds = false;
    } 

    return $this;
  }
}
