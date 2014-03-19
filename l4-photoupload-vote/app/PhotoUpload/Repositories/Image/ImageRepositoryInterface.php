<?php namespace PhotoUpload\Repositories\Image;

use PhotoUpload\Models\Image;

interface ImageRepositoryInterface {
  public function getAll();
  public function getById($id); 
  public function findAllForUser(User $user, $perPage = 9); 
  public function findAllFavorites(User $user, $perPage = 9);
  public function findAllPaginated($perPage = 9);
  public function findMostRecent($perPage = 9);
  public function findMostPopular($perPage = 9);
  public function findMostCommented($perPage = 9);
  public function incrementViews(Image $trick);
  public function findNextImage(Image $trick);
  public function findPrevious(Image $trick);
  public function findForFeed(); 
  public function edit(Image $trick, array $data);
  public function create(array $data);
}
