<?php namespace PhotoUpload\Repositories\Image;

use Illuminate\Database\Eloquent\Model;
use PhotoUpload\Repositories\AbstractRepository;
use PhotoUpload\Models\Image;
use PhotoUpload\Models\User;

class EloquentImageRepository extends AbstractRepository implements ImageRepositoryInterface {
  
  /**
   * model 
   * 
   * @var mixed
   */
  private $model;

  /**
   * Create a new EloquentImageRepository instance.
   *
   * @param  \PhotoUpload\Models\Tag $tags
   * @return void
   */
  function __construct(Model $model)
  {
    $this->model = $model;
  }

  /**
   * Get all the images for the given user paginated. 
   * 
   * @param mixed $id id 
   * @param int $perPage perPage 
   * 
   * @return void
   */
  public function getAllByUser(User $user, $perPage = 9)
  {
    $images = $user->images()
                  ->orderBy('created_at', 'DESC')
                  ->paginate($perPage);
    return $images;
  }

  /**     
   * Find all images that are favorited by the given user paginated.
   *      
   * @param  \PhotoUpload\Repositories\User $user
   * @param  integer $perPage
   * @return \Illuminate\Pagination\Paginator
   */   
  public function getAllFavorites(User $user, $perPage = 9)
  {     
      $images = $user->votes()->orderBy('created_at', 'DESC')->paginate($perPage);
        
      return $images;        
  }

  /**
   * Increment the view count on the given image.
   * 
   * @param mixed $id id 
   * 
   * @return void
   */
  public function incrementViews($id)
  {     
      $image = $this->model->find($id);
      $image->view_cache = $image->view_cache + 1;        
      $image->save();
        
      return $image;                             
  } 

  /**
   * getAllPaginated 
   * 
   * @param int $perPage perPage 
   * 
   * @return void
   */
  public function getAllPaginated($perPage = 9)
  {
      $images = $this->model->orderBy('created_at', 'DESC')->paginate($perPage);

      return $images;
  }

  /**
   * getMostRecent 
   * 
   * @param int $perPage perPage 
   * 
   * @return void
   */
  public function getMostRecent($perPage =9)
  {
    return $this->getAllPaginated($per_page);
  }

  /**
   * getMostPopular 
   * 
   * @param int $perPage perPage 
   * 
   * @return void
   */
  public function getMostPopular($perPage =9)
  {

  }

  /**
   * getMostCommented 
   * 
   * @param int $perPage perPage 
   * 
   * @return void
   */
  public function getMostCommented($perPage =9)
  {

  }

  /**
   * getNextImage 
   * 
   * @param Image $image image 
   * 
   * @return void
   */
  public function getNextImage(Image $image)
  {

  }

  /**
   * getPreviousImage 
   * 
   * @param Image $image image 
   * 
   * @return void
   */
  public function getPreviousImage(Image $image)
  {

  }

  /**
   * getNumberOfUser assoticated with image
   * 
   * @return void
   */
  public function getNumberOfUser()
  {
  }

  /**
   * getForFeed 
   * 
   * @param Image $image image 
   * 
   * @return void
   */
  public function getForFeed(Image $image)
  {

  }

  /**
   * store 
   * 
   * @param array $data data 
   * 
   * @return void
   */
  public function store(array $data)
  { 
      //$image->user_id = $data['user_id'];      
      $data = [
        title => $data['title'],
        slug => $data['title'],
        description => $data['description'],
      ];
    
      $image = $this->model->create($data);
      $image->tags()->sync($data['tags']);       
    
      return $image; 
  }

  /**
   * update 
   * 
   * @param mixed $id id 
   * @param array $data data 
   * 
   * @return void
   */
  public function update($id, array $data)
  {
      return $this->getById($id)->update($data);  
  }

  /**
   * getVotes 
   * 
   * @param mixed $id id 
   * 
   * @return void
   */
  public function getVotes($id)
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
