<?php namespace PhotoUpload\Repositories\Image;

use PhotoUpload\Repositories\DbRepository;
use Illuminate\Database\Eloquent\Model;

class DbImageRepository extends DbRepository implements ImageRepositoryInterface {
  
  private $model;

  function __construct(Model $model)
  {
    $this->model = $model;
  }
  
  public function getAll()
  {
    return $images = $this->model->with('users')->get()->toArray();
  }

  public function getById($id)
  {
    return $images = $this->model->with('users')->findOrFail($id);
  }


  public  function getVotes($id)
  {
    $images = $this->getById($id)->toArray();
    $votes = [];
    
    foreach($images['users'] as $user)
    {
      $votes[] = $user['pivot']['vote'];
    }

    $reduce = array_reduce($votes, function($v, $w){
      return $v+$w;
    });

    return $reduce;
  }

}
