<?php namespace PhotoUpload\Controllers\Web;

use PhotoUpload\Repositories\Image\ImageRepositoryInterface;

class SearchController extends WebController
{
    /**
     * Trick repository.
     *
     * @var \PhotoUpload\Repositories\Image\ImageRepositoryInterface
     */
    protected $images;

    /**
     * BaseController 
     * 
     * @var PhotoUpload\Controllers\Web
     */
    protected $base;

    /**
     * Create a new SearchController instance.
     *
     * @param  \PhotoUpload\Repositories\Image\ImageRepositoryInterface  $images
     * @param \PhotoUpload\Controllers\Web $base
     * @return void
     */
    public function __construct(
      ImageRepositoryInterface $images,
      BaseController $base
    ) {
      parent::__construct();

      $this->images = $images;
      $this->base = $base;
    }

    /**
     * Show the search results page.
     *
     * @return \Response
     */
    public function getIndex()
    {
      $term = e($this->base->request->get('q'));
      $images = null;

      if (! empty($term)) {
          $images = $this->images->searchByTermPaginated($term, 12);
      }

      return $this->base->view('search.result', compact('images', 'term'));
    }
}
