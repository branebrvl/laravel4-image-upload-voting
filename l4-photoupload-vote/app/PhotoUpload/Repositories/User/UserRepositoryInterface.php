<?php namespace PhotoUpload\Repositories\User;

interface UserRepositoryInterface {
  public function getAll();
  public function getById($id); 
}
