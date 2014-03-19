<?php namespace PhotoUpload\Services\Image\Upload;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ImageUploadInterface {
  public function errors();
  public function getJsonBody();
  public function handle(UploadedFile $file);
}

