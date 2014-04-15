<?php namespace Evolve\Render\Services\Image\Upload\Render;

use Evolve\Common\Services\Image\Upload\AbstractUpload;
use Evolve\Common\Services\Image\Upload\ImageUploadInterface;

class RenderThumbUpload extends AbstractUpload implements ImageUploadInterface {

  /**
   * Get size for image mainupulation resize action. 
   * 
   * 
   * @return string
   */
  protected function getPath()
  {
   return $this->config->get('image.thumb_path');
  }

  /**
   * Get size for image mainupulation resize action. 
   * 
   * 
   * @return int 
   */
  protected function getSize()
  {
    return $this->config->get('image.thumb_width');
  }

  /**
   * Construct the body of the JSON response.
   *
   * @param  string  $size
   * @param  string  $path
   * @return array
   */
  protected function setJsonBody($filename, $mime, $path)
  {
    $this->jsonBody = [
             'images' => [
               'size' => $this->getFileSize($path),
               'path' => $path,
             ]
           ];
  }
  /**
   * handle 
   * 
   * @param String $imagePath 
   * 
   * @return void
   */
  public function handle($imagePath)
  {
    $file = basename($imagePath); 
    //These parameters are related to the image processing class that we've included, not really related to Laravel
    $this->imageManip->make($imagePath)
                     ->resize($this->getSize(), $this->getSize())
                     ->crop($this->config->get('image.thumb_width'), $this->config->get('image.thumb_height'))
                     ->save($this->getPath() . '/' . $file, $this->quality);

    $this->succeeds = $this->imageManip->succeeds();
    
    if($this->succeeds) 
    {
      $this->setJsonBody('','', $this->getPath());
    } else {
      $this->errors = $this->imageManip->errors();
    }

    return $this;
  }
}
