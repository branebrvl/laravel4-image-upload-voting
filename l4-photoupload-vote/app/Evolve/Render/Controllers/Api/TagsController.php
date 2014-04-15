<?php namespace Evolve\Render\Controllers\Api;

use Evolve\Common\Controllers\ApiController;
use Evolve\Render\Services\Transformers\TagTransformer;
use Evolve\Common\Controllers\BaseController;
use Evolve\Render\Repositories\Tag\TagRepositoryInterface;
use Evolve\Render\Repositories\Image\ImageRepositoryInterface;
use Evolve\Render\Repositories\Tag\TagValidator;

class TagsController extends ApiController{


  /**
   * tagTransformer 
   * 
   * @var \Evolve\Render\Services\Transformers\TagTransformer
   */
  protected $tagTransformer;

  /**
   * Image repository.
   *
   * @var \Images\Repositories\ImageRepositoryInterface
   */
  protected $images;

  /**
   * Tag repository.
   *
   * @var \Evolve\Render\Repositories\Tag\TagRepositoyInterface
   */
  protected $tags;

  /**
   * validator 
   * 
   * @var \Evolve\Render\Repositories\Tag\TagValidator
   */
  protected $validator;

  /**
   * BaseController 
   * 
   * @var Evolve\Common\Controllers\Web\BaseController
   */
  protected $base;
  
  /**
   * Create a new TagsController instance.
   *
   * @param  \Evolve\Render\Services\Transformers\TagTransformer  $tagTransformer
   * @param  \Evolve\Render\Repositories\Tag\TagRepositoyInterface  $tags
   * @param  \Evolve\Render\Repositories\Tag\TagValidator $validator
   * @param  \Evolve\Common\Controllers\Web\BaseController
   *
   * @return void
   */
  function __construct(
    TagTransformer $tagTransformer,
    TagRepositoryInterface $tags, 
    ImageRepositoryInterface $images,
    TagValidator $validator,
    BaseController $base
  ) {
    $this->tagTransformer = $tagTransformer;
    $this->tags = $tags;
    $this->images = $images;
    $this->validator = $validator;
    $this->base = $base;
  }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($renderId)
	{
    $tags = $this->getTags($renderId);

    return $this->respond([
      'data' => $this->tagTransformer->transformCollection($tags->toArray())
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
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
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

  protected function getTags($renderId)
  {
    if($renderId)
    {
      $tags = $this->images
                    ->getById($renderId)
                    ->tags;
    } else {
      $tags = $this->tags
                    ->getAll();
    }

    return $tags;
  }

}
