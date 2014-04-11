<?php namespace Evolve\Render\Controllers\Web;

use Evolve\Common\Controllers\BaseController;
use Evolve\Common\Controllers\WebController;
use Evolve\Render\Repositories\Image\ImageRepositoryInterface;

class SearchController extends WebController
{

  /**
   * Trick repository.
   *
   * @var \Evolve\Render\Repositories\Image\ImageRepositoryInterface
   */
  protected $images;

  /**
   * BaseController 
   * 
   * @var \Evolve\Common\Controllers\Web
   */
  protected $base;

  /**
   * Create a new SearchController instance.
   *
   * @param  \Evolve\Render\Repositories\Image\ImageRepositoryInterface  $images
   * @param  \Evolve\Common\Controllers\Web\BaseController $base
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

    return $this->base
                ->view('search.result', compact('images', 'term'));
  }
}
