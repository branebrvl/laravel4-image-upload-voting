<?php namespace PhotoUpload\Repositories\User;

use PhotoUpload\Repositories\DbRepository;
use Illuminate\Database\Eloquent\Model;

class DBUserRepository extends DBRepository implements UserRepositoryInterface {

  private $model;

  function __construct(Model $model)
  {
    $this->model = $model;
  }

}
