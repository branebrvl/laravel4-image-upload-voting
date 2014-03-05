<?php namespace PhotoUpload\Repositories;

abstract class DbRepository
{
  public function getAll()
  {
    return $this->model->all();
  }
  
  public function getById($id)
  {
    return $this->model->find($id);
  } 
  
}
