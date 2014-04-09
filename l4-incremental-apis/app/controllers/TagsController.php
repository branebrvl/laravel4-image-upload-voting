<?php

use Acme\Transformers\TagTransformer;

class TagsController extends ApiController{


  /**
   * tagTransformer 
   * 
   * @var mixed
   */
  protected $tagTransformer;

  function __construct(TagTransformer $tagTransformer)
  {
    $this->tagTransformer = $tagTransformer;
  }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($lessonId)
	{
    $tags = $this->getTags($lessonId);

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

  protected function getTags($lessonId)
  {
    $tags = $lessonId ? Lesson::findOrFail($lessonId)->tags : Tag::all();

    return $tags;
  }

}
