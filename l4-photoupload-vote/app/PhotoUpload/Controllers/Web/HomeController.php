<?php namespace PhotoUpload\Controllers\Web;         

use PhotoUpload\Repositories\Image\ImageRepositoryInterface;

class HomeController extends BaseController
{
    /**
     * Image repository.       
     *
     * @var \Image\Repositories\ImageRepositoryInterface
     */
    protected $image;         
    
    /**
     * Create a new HomeController instance.
     *
     * @param  \Image\Repositories\ImageRepositoryInterface  $image
     * @return void
     */   
    public function __construct(ImageRepositoryInterface $image)
    {   
        $this->image = $image;        
    }   
        
    /** 
     * Show the homepage.
     *  
     * @return \Response
     */
    public function getIndex() 
    {
        $images = $this->image->getAllPaginated();
        // return \Response::make($image);
        $this->view('home.index', compact('images'));
    } 
      
    /**
     * Show the about page.    
     *
     * @return \Response       
     */
    public function getAbout() 
    { 
        $this->view('home.about');      
    } 
} 
