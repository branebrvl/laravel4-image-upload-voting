<?php namespace PhotoUpload\Services\Image\Upload\Avatar;

use PhotoUpload\Services\Image\Upload\AbstractUpload;
use PhotoUpload\Services\Image\Upload\ImageUploadInterface;

class AvatarUpload extends AbstractUpload implements ImageUploadInterface {


  /**
   * Get size for image mainupulation resize action. 
   * 
   * 
   * @return string
   */
  protected function getPath()
  {
   return $this->config('image.avatar_path');
  }

  /**
   * Get size for image mainupulation resize action. 
   * 
   * 
   * @return int 
   */
  protected function getSize()
  {
    return $this->config('image.avatar_width');
  }
}