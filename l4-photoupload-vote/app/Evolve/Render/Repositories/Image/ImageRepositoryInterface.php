<?php namespace Evolve\Render\Repositories\Image;

use Evolve\Render\Models\Image;

/**
 * ImageRepositoryInterface 
 * 
 */
interface ImageRepositoryInterface {

  /**
   * getAll 
   * 
   * 
   * @return void
   */
  public function getAll();
  
  /**
   *  
   */
  public function getById($id); 
  
  /**
   * getAllPaginated 
   * 
   * @param int $perPage perPage 
   * 
   * @return void
   */
  public function getAllPaginated($perPage = 12);
  
  /**
   * getMostRecent 
   * 
   * @param int $perPage perPage 
   * 
   * @return void
   */
  public function getMostRecent($perPage = 12);
  
  /**
   * getMostPopular 
   * 
   * @param int $perPage perPage 
   * 
   * @return void
   */
  public function getMostPopular($perPage = 12);
  
  /**
   * incrementViews 
   * 
   * @param \Illuminate\Database\Eloquent\Model $image image 
   * 
   * @return void
   */
  public function incrementViews(\Illuminate\Database\Eloquent\Model $image);
  
  /**
   * getNextImage 
   * 
   * @param Image $image image 
   * 
   * @return void
   */
  public function getNextImage(Image $image);
  
  /**
   * getPreviousImage 
   * 
   * @param Image $image image 
   * 
   * @return void
   */
  public function getPreviousImage(Image $image);
  
  /**
   * store 
   * 
   * @param array $data data 
   * 
   * @return void
   */
  public function store(array $data);
}
