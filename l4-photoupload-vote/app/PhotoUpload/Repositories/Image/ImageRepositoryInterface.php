<?php namespace PhotoUpload\Repositories\Image;

use PhotoUpload\Models\Image;

interface ImageRepositoryInterface {
  public function getAll();
  public function getById($id); 
  public function getAllPaginated($perPage = 9);
  public function getMostRecent($perPage = 9);
  public function getMostPopular($perPage = 9);
  public function getMostCommented($perPage = 9);
  public function incrementViews($id);
  public function getNextImage(Image $image);
  public function getPreviousImage(Image $image);
  public function getForFeed(Image $image); 
  public function update($id, array $data);
  public function store(array $data);
}
