<?php namespace PhotoUpload\Services\Image\Upload\Canvas;

use PhotoUpload\Services\Image\Upload\AbstractUpload;
use PhotoUpload\Services\Image\Upload\ImageUploadInterface;

class CanvasUpload extends AbstractUpload implements ImageUploadInterface {

  /**
   * Handle the file upload. Returns the response body on success, or false
   * on failure.
   *
   * @param  \Symfony\Component\HttpFoundation\File\UploadedFile  $file
   * @return array|bool
   */
  public function handle(UploadedFile $image)
  {
    parent::handle($image);

    //We upload the image first to the upload folder, then get make a thumbnail from the uploaded image
    $image->move($this->config('image.upload_path'), $this->makeFilename());
    
    
    return $this;
  }
}
