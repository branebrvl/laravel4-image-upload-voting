<?php namespace PhotoUpload\Repositories\Tag;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use PhotoUpload\Exceptions\TagNotFoundException;
use PhotoUpload\Repositories\AbstractRepository;
use PhotoUpload\Repositories\Tag\TagRepositoryInterface;

class EloquentTagRepository extends AbstractRepository implements TagRepositoryInterface {

  /**
   * model 
   * 
   * @var mixed
   */
  private $model;

    /**
     * Create a new EloquentTagRepository instance.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get an array of key-value (id => name) pairs of all tags.
     *
     * @return array
     */
    public function listAll()
    {
        $tags = $this->model->lists('name', 'id');

        return $tags;
    }

    /**
     * Find all tags.
     *
     * @param  string  $orderColumn
     * @param  string  $orderDir
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll($orderColumn = 'created_at', $orderDir = 'desc')
    {
        $tags = $this->model
                     ->orderBy($orderColumn, $orderDir)
                     ->get();

        return $tags;
    }

    /** 
     * Get a tag by id.
     *  
     * @param  mixed  $id      
     * @return \PhotoUpload\Models\Tag     
     */
    public function getById($id)   
    {     
        return $this->model->find($id); 
    } 

    /**
     * Get all tags with the associated number of images.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\PhotoUpload\Models\Tag[]
     * 
      SELECT `tags`.`name`, count(*) as `images_count`
      FROM `tags`
      INNER JOIN `image_tag`
      ON `tags`.`id` = `image_tag`.`user_id`
      GROUP BY `tags`.`id`
     *
     * @return void
     */
    public function getAllWithImageCount()
    {
        return $this->model
                    ->join('image_tag', 'tags.id', '=', 'image_tag.tag_id')
                    ->groupBy('tags.slug')
                    ->orderBy('image_count', 'desc')
                    ->get([
                        'tags.name',
                        'tags.slug',
                        DB::raw('COUNT(*) as image_count')
                    ]);
    }

    /** 
     * Get all images for the tag that matches the given slug.
     *  
     * @param  string $slug
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Images\Image[]
     */ 
    public function getImagesByTag($slug, $perPage = 9)
    {
        $tag = $this->model->whereSlug($slug)->first();
    
        if (is_null($tag)) {   
            throw new TagNotFoundException('The tag "' . $slug . '" does not exist!'); 
        }
      
        $images = $tag->images()->orderBy('created_at', 'desc')->paginate($perPage);
      
        return [ $tag, $images ];       
    } 


    /**
     * Create a new tag in the database.
     *
     * @param  array  $data
     * @return \PhotoUpload\Models\Tag
     */
    public function store(array $data)
    {
      $data = [
        'name' => $data['name'],
        'slug' => $data['name']
      ];

      return $this->model->create($data);
    }

    /**
     * Update the specified tag in the database.
     *
     * @param  mixed  $id
     * @param  array  $data
     * @return \PhotoUpload\Models\Tag
     */
    public function update($id, array $data)
    {
      $data = [
        'name' => $data['name'],
        'slug' => $data['name']
      ];

       return $this->getById($id)->update($data);
    }

    /**
     * Delete the specified tag from the database.
     *
     * @param  mixed  $id
     * @return void
     */
    public function delete($id)
    {
        $tag = $this->getById($id);

        $tag->images()->detach();

        $tag->delete();
    }
}
