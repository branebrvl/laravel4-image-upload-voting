<?php namespace Evolve\Render\Controllers\Api;

use Evolve\Common\Controllers\BaseController;
use Evolve\Common\Controllers\ApiController;
use Evolve\Render\Services\Transformers\RenderTransformer;
use Evolve\Render\Repositories\Image\ImageRepositoryInterface;

class RendersController extends ApiController{

  /**
   * renderTransformer 
   * 
   * @var \Evolve\Render\Services\Transformers\RenderTransformer
   */
  protected $renderTransformer;

  /**
   * Image repository.
   *
   * @var \Images\Repositories\ImageRepositoryInterface
   */
  protected $images;

  /**
   * BaseController 
   * 
   * @var \Evolve\Common\Controllers\Web
   */
  protected $base;
  
  /**
   * Create a new ImagesController instance.
   *
   * @param \Evolve\Render\Repositories\ImageRepositoryInterface  $images
   * @param  \Evolve\Common\Controllers\Web\BaseController $base
   * @return void
   */
  public function __construct (
    RenderTransformer $renderTransformer,
    ImageRepositoryInterface $images,
    BaseController $base
  ) {
    // parent::__construct();
    $this->beforeFilter('auth.basic', ['on' => 'post']);

    $this->renderTransformer = $renderTransformer;
    $this->images = $images;
    $this->base = $base;
  }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
  {
    $lessons = $this->images->getAll();

    return $this->respond([
       'data'=> $this->renderTransformer->transformCollection($lessons->toArray())
      ]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
    $data= $this->base
                ->request
                ->only(['title', 'description', 'tags', 'render']);

    if ($this->validator->with($data)->fails()) 
    {
      return $this->base
                  ->redirectBack([
                      'errors' => $this->validator->errors(),
                      'render' => $data['render']
                    ]);
    }

    $data['user_id'] = $this->base->auth->user()->id;

    $images = $this->images->store($data);

    return $this->respondCreated('Image successfully created!');
  }
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
    $lesson = $this->images->getById($id);
    
    if( !$lesson ){
      return $this->respondNotFound('Image does not exist');
    } 

    return $this->respond([
      'data' => $this->renderTransformer->transform($lesson->toArray())
    ]);
    
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
