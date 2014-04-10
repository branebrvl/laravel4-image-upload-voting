<?php namespace PhotoUpload\Repositories\Image;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\Repository as Config;
use PhotoUpload\Repositories\AbstractRepository;
use PhotoUpload\Models\Image;
use PhotoUpload\Models\User;
use PhotoUpload\Services\Image\Upload\Render\RenderThumbUpload;

class EloquentImageRepository extends AbstractRepository implements ImageRepositoryInterface {
  
  /**
   * model 
   * 
   * @var mixed
   */
  protected $model;

  /**
   * config 
   * 
   * @var mixed
   */
  protected $config;

  /**
   * filesysteml 
   * 
   * @var mixed
   */
  protected $filesysteml;

  /**
   * renderThumbUpload 
   * 
   * @var mixed
   */
  protected $renderThumbUpload;

  /**
   * Create a new EloquentImageRepository instance.
   *
   * @param  \Illuminate\Database\Eloquent\Model $model
   * @param \Illuminate\Filesystem\Filesystem  $filesystem
   * @return void
   */
  function __construct(
    Model $model, 
    Filesystem $filesystem, 
    Config $config, 
    RenderThumbUpload $renderThumbUpload
  ) {
    $this->model = $model;
    $this->filesystem = $filesystem;
    $this->config = $config;
    $this->renderThumbUpload = $renderThumbUpload;
  }

  /**
   * Get all the images for the given user paginated. 
   * 
   * @param mixed $id id 
   * @param int $perPage perPage 
   * 
   * @return \Illuminate\Pagination\Paginator
   */
  public function getAllByUser(User $user, $perPage = 9)
  {
    $images = $user
                  ->images()
                  // ->with('tags','users.images')
                  ->orderBy('created_at', 'DESC')
                  ->paginate($perPage) 
                  // ->get()
                  ;

    return $images;
  }

  /**     
   * Find all images that are favorited by the given user paginated.
   *      
   * @param  \PhotoUpload\Models\User $user
   * @param  integer $perPage
   * @return \Illuminate\Pagination\Paginator
   */   
  public function getAllFavorites(User $user, $perPage = 9)
  {     
    $images = $user->votes()
                   ->orderBy('created_at', 'DESC')
                   ->paginate($perPage);

      return $images;        
  }

  /**
   * Increment the view count on the given image.
   * 
   * @param PhotoUpload\Models\Image $image
   * 
   * @return PhotoUpload\Models\Image
   */
  public function incrementViews(\Illuminate\Database\Eloquent\Model $image)
  {     
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
    $images = $this->model
                    ->whereHas('user', function ($query) {
                        $query->whereNULL('blocked_at');   
                    })                         
                   ->orderBy('created_at', 'DESC')
                   ->paginate($perPage);

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
    return $this->getAllPaginated($perPage);
  }

  /** 
   * Find an image by the given slug.
   * 
   * @param  string $slug 
   * @return \PhotoUpload\Models\Image
   */
  public function getBySlug($slug) 
  { 
    return $this->model
                ->whereSlug($slug)
                ->first(); 
  }

  /**
   * Get a list of tag ids that are associated with the given image.
   *
   * @param  \PhotoUpload\Models\Image $image
   * @return array
   */
  public function listTagsIdsForImage(Image $image)
  {
      return $image->tags->lists('id');
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
    $next = $this->model
                  ->whereHas('user', function ($query) {
                      $query->whereNULL('blocked_at');   
                  })                         
                  ->where(function($query) use($image)
                  {
                    $query->where('created_at', '>=', $image->created_at)
                          ->where('id', '<>', $image->id); 
                  })
                  ->orderBy('created_at', 'asc')  
                  ->first([ 'slug', 'title' ]);   

    return $next; 
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
    $prev = $this->model
                  ->whereHas('user', function ($query) {
                      $query->whereNULL('blocked_at');   
                  })                         
                  ->where(function($query) use($image)
                  {
                    $query->where('created_at', '<=', $image->created_at)
                          ->where('id', '<>', $image->id); 
                  })
                  ->orderBy('created_at', 'desc') 
                  ->first([ 'slug', 'title' ]);   

    return $prev; 
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
   * Find all images that match the given search term.
   *  
   * @param  string $term                        
   * @param  integer $perPage                    
   * @return \Illuminate\Pagination\Paginator
   */
  public function searchByTermPaginated($term, $perPage = 12)
  {
    $tricks = $this->model                    
                  ->whereHas('user', function ($query) 
                  {
                    $query->whereNULL('blocked_at');   
                  })                         
                  ->where(function($query) use($term)
                  {
                    $query->orWhere('title', 'LIKE', '%'.$term.'%')           
                          ->orWhere('description', 'LIKE', '%'.$term.'%')     
                          ->orWhereHas('tags', function ($query) use ($term) 
                          {
                            $query->where('slug', 'LIKE', '%' . $term . '%');   
                          })
                          ->orWhereHas('tags', function ($query) use ($term) 
                          {
                            $query->where('name', 'LIKE', '%' . $term . '%');   
                          });
                  })
                  ->orderBy('created_at', 'desc')                     
                  ->orderBy('title', 'asc')  
                  ->paginate($perPage);      

      return $tricks;
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
    $imgMin = '';
    $tags = $data['tags'];

    $imgBigTmpPath = $this->config->get('image.upload_path_tmp') . '/' .$data['render'];
    $imgBigPath = $this->config->get('image.upload_path') . '/' . $data['render'];
    $this->filesystem->move($imgBigTmpPath, $imgBigPath);
    $this->renderThumbUpload->handle($imgBigPath); 

    if($this->renderThumbUpload->succeeds())
    {
      $imgMin = $this->renderThumbUpload->getJsonBody()['images']['path'];
    }

    $data = [
      'user_id' => $data['user_id'],
      'title' => $data['title'],
      'slug' => $data['title'],
      'description' => $data['description'],
      'img_big' => $data['render'],
      'img_min' => $data['render'], 
    ];

    $image = $this->model->create($data);
    $image->tags()->sync($tags);       
    
    return $image; 
  }

    /**     
     * Update the trick in the database.                                                                              
     *      
     * @param  \Tricks\Trick $trick
     * @param  array $data                                                                                            
     * @return \Tricks\Trick                                                                                          
     */                                                                                                               
    public function edit(Image $image, array $data)                                                                   
    {
        //$trick->user_id = $data['user_id'];
        $image->title       = $data['title'];                                                                      
        $image->slug        = $data['title'];                                                         
        $image->description = $data['description'];                                                                
    
        $image->save();
                                                                                                                      
        $image->tags()->sync($data['tags']);
                                                                                                                      
        return $image;
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
