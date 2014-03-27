<?php namespace PhotoUpload\Repositories\Tag;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use PhotoUpload\Exceptions\TagNotFoundException;
use PhotoUpload\Repositories\DbRepository;
use PhotoUpload\Repositories\TagRepositoryInterface;

class TagRepository extends DbRepository implements TagRepositoryInterface {

  /**
   * model 
   * 
   * @var mixed
   */
  private $model;

  /**
   * strc 
   * 
   * @var mixed
   */
  private $strc;

    /**
     * Create a new EloquentTagRepository instance.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param $strc
     * @return void
     */
    public function __construct(Model $model, $strc)
    {
        $this->model = $model;
        $this->strc = $strc;
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
    public function getAllWithTrickCount()
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
     * Create a new tag in the database.
     *
     * @param  array  $data
     * @return \PhotoUpload\Models\Tag
     */
    public function store(array $data)
    {
      $data = [
        'name' => $data['name'],
        'slug' => $this->str->slug($tag->name, '-')
      ];

      return $tag->model->create($data);
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
        'slug' => $this->str->slug($tag->name, '-')
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
