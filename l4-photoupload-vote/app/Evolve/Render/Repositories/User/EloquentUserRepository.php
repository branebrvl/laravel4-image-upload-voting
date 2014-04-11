<?php namespace Evolve\Render\Repositories\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem; 
use Illuminate\Config\Repository as Config;
use Evolve\Common\Repositories\AbstractRepository;
use Evolve\Render\Models\User;
use Evolve\Render\Exceptions\UserNotFoundException;

class EloquentUserRepository extends AbstractRepository implements UserRepositoryInterface {

  /**
   * Model instance
   * 
   * @var \Illuminate\Config
   */
  protected $model;

  /**
   * Filesystem instance.    
   *
   * @var \Illuminate\Filesystem\Filesystem
   */
  protected $filesystem;

  /**
   * Config instance.    
   *
   * @var \Illuminate\Config
   */
  protected $config;

  /**
  * Create a new EloquentUserRepository instance.   
  *
  * @param \Illuminate\Database\Eloquent\Model $model
  * @param \Illuminate\Filesystem\Filesystem  $filesystem
  * @param \Illuminate\Config\Repsitory $config
  * @return void
  */
  function __construct(Model $model, Filesystem $filesystem, Config $config)
  {
    $this->model = $model;
    $this->filesystem = $filesystem;
    $this->config = $config;
  }

  /** 
   * Get a user by id.
   *  
   * @param  mixed  $id      
   * @return \Evolve\Render\Models\User     
   */
  public function getById($id)   
  {     
      return $this->model->findOrFail($id); 
  } 

  /** 
   * Get all users paginated.
   *  
   * @param  int  $perPage
   * @return Illuminate\Database\Eloquent\Collection]
   */
  public function getAllPaginated($perPage = 200)
  { 
    return $this->model    
                ->orderBy('created_at', 'desc') 
                ->paginate($perPage);           
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
   * Find a user by it's username.
   *
   * @param  string $username
   * @return \Evolve\Render\Models\User
   */
  public function getByUsername($username)
  {
      return $this->model->whereUsername($username)->first();
  }

  /** 
   * Require a user by it's username.
   *
   * @param  string $username
   * @return \Evolve\Render\Models\User    
   * @throws \Evolve\Render\Exceptions\UserNotFoundException
   */ 
  public function requireByUsername($username)
  {
      if (! is_null($user = $this->getByUsername($username))) {
          return $user;
      } 
        
      throw new UserNotFoundException('The user "' . $username . '" does not exist!');
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
   * @param  \Evolve\Render\Model\User  $user
   * @param  array $data     
   * @return \Evolve\Render\Model\User
   */
  public function updateSettings(User $user, array $data)
  {
      $user->username = $data['username'];
      $user->password = ($data['password'] != '') ? $data['password'] : $user->password;
      
      if ($data['avatar'] != '') {
          $this->filesystem->move($this->config->get('image.avatar_path_tmp') . '/' .$data['avatar'], $this->config->get('image.avatar_path') . '/' . $data['avatar']);
          
          if ($user->photo) {
              $this->filesystem->delete($this->config->get('image.avatar_path') . '/' . $user->photo);
          }   
          
          $user->photo = $data['avatar'];
      }   
      
      return $user->save();
  }

    /**
     * Delete the specified user from the database.
     *
     * @param  mixed  $id
     * @return void
     */
    public function delete($id)
    {
      $user = $this->getById($id);

      $user->votes()->detach();
      $user->delete();
    }
}
