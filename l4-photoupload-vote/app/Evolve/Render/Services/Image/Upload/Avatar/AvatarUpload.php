<?php namespace Evolve\Render\Services\Image\Upload\Avatar;

use Evolve\Common\Services\Image\Upload\AbstractUpload;
use Evolve\Common\Services\Image\Upload\ImageUploadInterface;

class AvatarUpload extends AbstractUpload implements ImageUploadInterface {


  /**
   * Get size for image mainupulation resize action. 
   * 
   * 
   * @return string
   */
  protected function getPath()
  {
   return $this->config->get('image.avatar_path_tmp');
  }

  /**
   * Get size for image mainupulation resize action. 
   * 
   * 
   * @return int 
   */
  protected function getSize()
  {
    return $this->config->get('image.avatar_width');
  }
}
