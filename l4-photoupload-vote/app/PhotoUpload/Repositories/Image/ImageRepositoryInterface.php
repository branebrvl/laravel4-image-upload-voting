<?php namespace PhotoUpload\Repositories\Image;

interface ImageRepositoryInterface {
  public function getAll();
  public function getById($id); 
}
