<?php namespace Evolve\Render\Repositories\User;

interface UserRepositoryInterface {
  /**
   * getByIdImages 
   * 
   * @param mixed $id id 
   * @param int $perPage perPage 
   * 
   * @return void
   */
  public function getByIdImages($id, $perPage = 9);
  /**
   * getByIdFavorites 
   * 
   * @param mixed $id id 
   * @param int $perPage perPage 
   * 
   * @return void
   */
  public function getByIdFavorites($id, $perPage = 9);
  /**
   * getAllImagesCount 
   * 
   * 
   * @return void
   */
  public function getAllImagesCount();
  /**
   * getByIdImagesCount 
   * 
   * @param mixed $id id 
   * 
   * @return void
   */
  public function getByIdImagesCount($id);
  /**
   * getAllVotesCount 
   * 
   * 
   * @return void
   */
  public function getAllVotesCount();
  /**
   * getByIdVotesCount 
   * 
   * @param mixed $id id 
   * 
   * @return void
   */
  public function getByIdVotesCount($id);
  /**
   * store 
   * 
   * @param array $data data 
   * 
   * @return void
   */
  public function store(array $data);
}
