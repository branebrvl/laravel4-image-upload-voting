<?php namespace PhotoUpload\Services\Image\Manipulation;

use Intervention\Image\Facades\Image;
/**
 * 
 */
class ImageManip implements ImageManipInterface
{

  protected $image;
  /**
   * 
   */
  public function __construct(Image $image)
  {
    $this->image = $image; 
  }

  public function resize($width, $height)
  {
            try
            {
              $this->image->make(Config::get('image.upload_path') . '/' . $fullname)
                      ->resize(Config::get('image.thumb_width'), null, true)
                      ->save(Config::get('image.thumb_path') . '/' . $fullname);
            }         
            catch (Exception $e)
            {
              Log::error('[IMAGE SERVICE] Failed to resize image "' . $fullname . '" [' . $e->getMessage() . ']');
            } 
  }
}
