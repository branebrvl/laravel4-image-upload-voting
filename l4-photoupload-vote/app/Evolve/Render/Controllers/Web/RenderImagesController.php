<?php namespace Evolve\Render\Controllers\Web;

use Illuminate\Support\Facades\Response;
use Evolve\Common\Controllers\BaseController;
use Evolve\Common\Controllers\WebController;
use Evolve\Render\Repositories\Tag\TagRepositoryInterface;
use Evolve\Render\Repositories\Image\ImageRepositoryInterface;
use Evolve\Render\Repositories\Image\RenderEditValidator;
use Evolve\Render\Repositories\Image\RenderValidator;
use Evolve\Render\Services\Image\Upload\Render\RenderUpload;

class RenderImagesController extends WebController
{

  /**
   * Image repository.
   *
   * @var \Evolve\Render\Repositories\Image\ImageRepositoryInterface
   */
  protected $images;

  /**
   * Tag repository.
   *
   * @var \Evolve\Render\Repositories\Tag\TagRepositoryInterface
   */
  protected $tags;

  /**
   * Validator service
   * 
   * @var \Evolve\Render\Repositories\Image\RenderValidator
   */
  protected $validator;

  /**
   * Validator service
   * 
   * @var \Evolve\Render\Repositories\Image\RenderEditValidator
   */
  protected $validatorEdit;

  /**
   * Render Upload service
   * 
   * @var  \Evolve\Render\Services\Image\Upload\Render
   */
  protected $renderUpload;

  /**
   * BaseController 
   * 
   * @var Render\Controllers\Web
   */
  protected $base;

  /**
   * Create a new ImageController instance.
   *
   * @param  \Evolve\Render\Repositories\Image\ImageRepositoryInterface  $images
   * @param  \Evolve\Render\Repositories\Tag\TagRepositoryInterface  $tags
   * @param  \Evolve\Render\Repositories\Image\RenderValidator $validator
   * @param  \Evolve\Render\Repositories\Image\RenderEditValidator $validatorEdit
   * @param  \Evolve\Render\Services\Image\Upload\Render\RenderUpload $renderUpload
   * @param  \Evolve\Common\Controllers\Web\BaseController $base
   *
   * @return void
   */
  public function __construct(
    ImageRepositoryInterface $images,
    TagRepositoryInterface $tags,
    RenderValidator $validator,
    RenderEditValidator $validatorEdit,
    RenderUpload $renderUpload,
    BaseController $base
  ) {
    parent::__construct();

    $this->beforeFilter('auth');

    $this->images = $images;
    $this->tags = $tags;
    $this->validator = $validator;
    $this->validatorEdit =  $validatorEdit;
    $this->renderUpload = $renderUpload;
    $this->base = $base;
  }

  /**
   * Show the create new images page.
   *
   * @return \Response
   */
  public function getNew()
  {
    $tagList = $this->tags->listAll();

    return $this->base->view('render.new', compact('tagList'));
  }

  /**
   * Handle the creation of a new images.
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postNew()
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

    return $this->base
                ->redirectRoute('user.index');
  }

  /**
   * Show the edit images page.
   *
   * @param  string $slug
   * @return \Response
   */
  public function getEdit($slug)
  {
    $images = $this->images->getBySlug($slug);
    $tagList = $this->tags->listAll();

    $selectedTags = $this->images->listTagsIdsForImage($images);

    return $this->base
                ->view('render.edit', [
                  'tagList' => $tagList,
                  'selectedTags' => $selectedTags,
                  'image' => $images
                ]);
  }

  /**
   * Handle the render upload.
   *
   * @return \Illuminate\Http\Response
   */
  public function postRender()
  {
    $upload = $this->renderUpload->handle($this->base->request->file('filedata'));

    if ($upload->succeeds()) 
    {
      return Response::json($upload->getJsonBody(), 200);
    }

    return Response::json('error', 400);
  }

  /**
   * Handle the editting of a images.
   *
   * @param  string $slug
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postEdit($slug)
  {
    $data= $this->base
                ->request
                ->only(['title', 'description', 'tags']);

    $image = $this->images->getBySlug($slug);

    if ($this->validatorEdit->with($data, $image->id)->fails()) 
    {
      return $this->base->redirectBack([ 'errors' => $this->validatorEdit->errors()]);
    }

    $image = $this->images->edit($image, $data);

    return $this->base
                ->redirectRoute('images.edit', [ $image->slug ], [
                  'success' => 'Render has been updated'
                ]);
  }

  /**
   * Delete a images from the database.
   *
   * @param  string $slug
   * @return \Illuminate\Http\RedirectResponse
   */
  public function getDelete($slug)
  {
    $images = $this->images->getBySlug($slug);

    if ($images->user_id != $this->base->auth->user()->id) 
    {
      return "This render doesn't belong to you";
    }

    $images->tags()->detach();
    $images->delete();

    return $this->base
                ->redirectRoute('user.index', null, [
                  'success' => 'Image has been deleted'
                ]);
  }
}
