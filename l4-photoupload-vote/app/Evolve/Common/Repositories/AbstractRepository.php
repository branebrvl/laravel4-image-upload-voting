<?php namespace Evolve\Common\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository {

  /**
   * Create a new DbRepository instance.
   *
   * @param  \Illuminate\Database\Eloquent\Model $model
   * @return void
   */
  public function __construct(Model $model)
  {
    $this->model = $model;
  }

  /**
   * Find all models.
   *
   * @param  string  $orderColumn
   * @param  string  $orderDir
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function getAll()
  {
    return $this->model->all();
  }
  
  /**
   * Find a model by id.
   *
   * @param  mixed  $id
   * @return \Evolve\Common\Models
   */
  public function getById($id)
  {
    return $this->model->find($id);
  } 
}
