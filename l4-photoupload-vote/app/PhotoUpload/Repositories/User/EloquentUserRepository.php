<?php namespace PhotoUpload\Repositories\User;

use PhotoUpload\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Model;

class EloquentUserRepository extends AbstractRepository implements UserRepositoryInterface {

  private $model;

  function __construct(Model $model)
  {
    $this->model = $model;
  }

  /**
   * Get all the images the given user has uploaded paginated. 
   * 
   * @param mixed $id id 
   * @param int $perPage perPage 
   * 
   * @return void
   */
  public function getByIdImages($id, $perPage = 9)
  {
    $users = $this->model
                   ->findOrFail($id)
                   ->images()
                   ->orderBy('created_at', 'DESC')
                   ->paginate($perPage);
    return $users;
  }

  /**
   * Get all images that are favorited by the given user paginated. 
   * 
   * @param mixed $id id 
   * @param int $perPage perPage 
   * 
   * @return void
   */
  public function getByIdFavorites($id, $perPage = 9)
  {
    $users = $this->model
                  ->findOrFail($id)
                  ->votes()
                  ->get();
    return $users;
  }

  /**
   * Get number of images a user has uploaded
   * 
    SELECT `users`.`username`, count(*) as `images_count`
    FROM `users`
    INNER JOIN `images`
    ON `users`.`id` = `images`.`user_id`
    GROUP BY `users`.`id`
   *
   * @return void
   */
  public function getAllImagesCount()
  {
    $users = $this->model
                  ->join('images', 'images.user_id', '=', 'users.id')
                  ->groupBy('users.username')
                  ->get([
                      'users.username', 
                      'users.id', 
                      DB::raw('count(*) as images_count')
                  ]);
    return $users;
  }

  /**
   * getByIdNumberOfImages 
   * 
   * @param mixed $id id 
   * 
   * @return void
   */
  public function getByIdImagesCount($id)
  {
    return $this->model->find($id)->images()->count();
  }

  /**
   * Get number of images a user has voted for 
   * 
    SELECT `users`.`username`, users.id, count(*) as `images_count`
    FROM `users`
    INNER JOIN `votes`
    ON `users`.`id` = `votes`.`user_id`
    GROUP BY `users`.`id`
   *
   * @return void
   */
  public function getAllVotesCount()
  {
    $users = $this->model
                  ->join('votes', 'votes.user_id', '=', 'users.id')
                  ->groupBy('users.username')
                  ->get([
                      'users.username', 
                      'users.id', 
                      DB::raw('count(*) as images_count')
                  ]);

    return $users;
  }

  public function getByIdVotesCount($id)
  {
    return $this->model->find($id)->votes()->count();
  }

  /**
   * Create a new user in the database.
   * 
   * @param array $data data 
   * 
   * @return void
   */
  public function store(array $data)
  {
    return $this->model->create([
      'email' => $data['email'],
      'password' => $data['password'],
      'username' => $data['username'],
    ]);
  }

  /**
   * Update the user's settings.
   *
   * @param  \PhotoUpload\Model\User  $user
   * @param  array $data     
   * @return \PhotoUpload\Model\User
   */
  public function updateSettings(User $user, array $data)
  {
      $user->username = $data['username'];
      $user->password = ($data['password'] != '') ? $data['password'] : $user->password;
      
      if ($data['avatar'] != '') {
          File::move(public_path().'/img/avatar/temp/'.$data['avatar'], 'img/avatar/'.$data['avatar']);
          
          if ($user->photo) {
              File::delete(public_path().'/img/avatar/'.$user->photo);
          }   
          
          $user->photo = $data['avatar'];
      }   
      
      return $user->save();
  }
}
