<?php namespace PhotoUpload\Services\Image\Manipulation\Intervention;

use Intervention\Image\Image;
use PhotoUpload\Services\Image\Manipulation\ImageManipInterface;
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

  public function succeeds()  
  {
      return $this->succeeds;  
  }

  public function make($path)
  {
    $this->image = $this->image->make($path);

    return $this;
  }

  public function save($path, $quality)
  {
    $this->image->save($path, $quality);

    return $this;
  }

  public function resize($width, $height)
  {
    try
    {
      $this->image->resize($width, $height, true, false);
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
