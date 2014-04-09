<?php namespace PhotoUpload\Controllers\Web;         

use PhotoUpload\Repositories\Image\ImageRepositoryInterface;

class HomeController extends WebController
{
    /**
     * Image repository.       
     *
     * @var \Image\Repositories\ImageRepositoryInterface
     */
    protected $image;         

    /**
     * BaseController 
     * 
     * @var PhotoUpload\Controllers\Web
     */
    protected $base;
    
    /**
     * Create a new HomeController instance.
     *
     * @param \Image\Repositories\ImageRepositoryInterface  $image
     * @param \PhotoUpload\Controllers\Web $base
     * @return void
     */   
    function __construct(
      ImageRepositoryInterface $image,
      BaseController $base
    ) {   
      parent::__construct();

      $this->image = $image;        
      $this->base = $base;
    }   

    /** 
     * Show the homepage.
     *  
     * @return \Response
     */
    public function getIndex() 
    {
        $images = $this->image->getAllPaginated();
        // return \Response::make($images);
        return $this->base->view('home.index', compact('images'));
    } 
      
    /**
     * Show the about page.    
     *
     * @return \Response       
     */
    public function getAbout() 
    { 
      return $this->base->view('home.about');      
    } 
} 
