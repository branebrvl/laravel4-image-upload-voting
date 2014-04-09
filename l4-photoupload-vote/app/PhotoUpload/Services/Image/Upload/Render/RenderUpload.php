<?php namespace PhotoUpload\Services\Image\Upload\Render;

use PhotoUpload\Services\Image\Upload\AbstractUpload;
use PhotoUpload\Services\Image\Upload\ImageUploadInterface;

class RenderUpload extends AbstractUpload implements ImageUploadInterface {

  /**
   * Get size for image mainupulation resize action. 
   * 
   * 
   * @return string
   */
  protected function getPath()
  {
   return $this->config->get('image.upload_path_tmp');
  }

  /**
   * Get size for image mainupulation resize action. 
   * 
   * 
   * @return int 
   */
  protected function getSize()
  {
    return $this->config->get('image.render_width');
  }
}
