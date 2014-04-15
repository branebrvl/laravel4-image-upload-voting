<?php namespace Evolve\Render\Controllers\Web;

use Evolve\Common\Controllers\BaseController;
use Evolve\Common\Controllers\WebController;
use Evolve\Render\Repositories\Image\ImageRepositoryInterface;
use Evolve\Render\Repositories\Tag\TagRepositoryInterface;

class BrowseController extends WebController
{

  /**
   * Image repository.
   *
   */
  protected $images;

  /**
   * Tag repository.
   * 
   */
  protected $tags;

  /**
   * BaseController 
   * 
   * @var \Evolve\Common\Controllers\Web
   */
  protected $base;

  /**
   * Create a new BrowseController instance.
   *
   * @return void
   */
  public function __construct(
    ImageRepositoryInterface $images, 
    TagRepositoryInterface $tags,
    BaseController $base
  ) { 
    parent::__construct();

    $this->images = $images;
    $this->tags = $tags;
    $this->base = $base;
  }

  /**
   * Show the tags index.    
   *
   * @return \Response
   */
  public function getTagIndex()   
  {
    $tags = $this->tags->getAllWithImageCount();

    return $this->base
                ->view('browse.tags', compact('tags'));
  } 
      
  /** 
   * Show the browse by tag page.
   *  
   * @param  string  $tag    
   * @return \Response
   */ 
  public function getBrowseTag($tag)
  {   
    list($tag, $images) = $this->tags->getImagesByTag($tag); 
    
    $type = 'Tag "'.$tag->name.'"';
    $pageTitle = 'Browsing Tag "' . $tag->name . '"';

    return $this->base
                ->view('browse.index', compact('images', 'type', 'pageTitle'));
  }

  /**
   * Show the browse recent image page.
   *
   * @return \Response
   */
  public function getBrowseRecent()
  {
    $images = $this->images->getMostRecent();

    $type = 'Recent';
    $pageTitle = 'Browsing Most Recent Photos';

    return $this->base
                ->view('browse.index', compact('images', 'type', 'pageTitle'));
  }

  /**
   * Show the browse popular image page.
   *
   * @return \Response
   */
  public function getBrowsePopular()
  {
    $images = $this->images->getMostPopular();

    $type = 'Popular';
    $pageTitle = 'Browsing Most Popular Photos';

    return $this->base
                ->view('browse.index', compact('images', 'type', 'pageTitle'));
  }

  /**
   * Show the browse most commented images page.
   *
   * @return \Response
   */
  public function getBrowseComments()
  {
    $images = $this->images->findMostCommented();

    $type = 'Most commented';
    $pageTitle = 'Browsing Most Commented Photos';

    return $this->base
                ->view('browse.index', compact('images', 'type', 'pageTitle'));
  }
}
