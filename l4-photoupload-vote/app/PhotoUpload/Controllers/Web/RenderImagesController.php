<?php namespace PhotoUpload\Controllers\Web;

use Illuminate\Support\Facades\Response;
use PhotoUpload\Repositories\Tag\TagRepositoryInterface;
use PhotoUpload\Repositories\Image\ImageRepositoryInterface;
use PhotoUpload\Repositories\Image\RenderEditValidator;
use PhotoUpload\Repositories\Image\RenderValidator;
use PhotoUpload\Services\Image\Upload\Render\RenderUpload;

class RenderImagesController extends WebController
{
    /**
     * Image repository.
     *
     * @var \PhotoUpload\Repositories\Image\ImageRepositoryInterface
     */
    protected $images;

    /**
     * Tag repository.
     *
     * @var \PhotoUpload\Repositories\Tag\TagRepositoryInterface
     */
    protected $tags;

    /**
     * Validator service
     * 
     * @var \PhotoUpload\Repositories\Image\RenderValidator
     */
    protected $validator;

    /**
     * Validator service
     * 
     * @var \PhotoUpload\Repositories\Image\RenderEditValidator
     */
    protected $validatorEdit;

    /**
     * Render Upload service
     * 
     * @var  \PhotoUpload\Services\Image\Upload\Render
     */
    protected $renderUpload;

    /**
     * BaseController 
     * 
     * @var PhotoUpload\Controllers\Web
     */
    protected $base;

    /**
     * Create a new ImageController instance.
     *
     * @param  \PhotoUpload\Repositories\Image\ImageRepositoryInterface  $images
     * @param  \PhotoUpload\Repositories\Tag\TagRepositoryInterface  $tags
     * @param  \PhotoUpload\Repositories\Image\RenderValidator $validator
     * @param  \PhotoUpload\Repositories\Image\RenderEditValidator $validatorEdit
     * @param  \PhotoUpload\Services\Image\Upload\Render\RenderUpload $renderUpload
     * @param \PhotoUpload\Controllers\Web $base
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
     * TODO think about enabling adding tasks as a form field.
     */
    public function getNew()
    {
      $tagList = $this->tags->listAll();

      return $this->base->view('tricks.new', compact('tagList'));
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

        return $this->base->redirectRoute('user.index');
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

        return $this->base->view('tricks.edit', [
                 'tagList' => $tagList,
                 'selectedTags' => $selectedTags,
                 'trick' => $images
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

      if ($upload->succeeds()) {
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
      $data= $this->request
                  ->only(['title', 'description', 'tags']);

      $image = $this->images->getBySlug($slug);

      if ($this->validatorEdit->with($data, $image->id)->fails()) 
      {
          return $this->base->redirectBack([ 'errors' => $this->validatorEdit->errors()]);
      }

      $image = $this->images->edit($image, $data);

      return $this->base->redirectRoute('images.edit', [ $image->slug ], [
          'success' => 'Image has been updated'
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

      if ($images->user_id != $this->base->auth->user()->id) {
          return "This images doesn't belong to you";
      }

      $images->tags()->detach();
      $images->delete();

      return $this->base->redirectRoute('user.index', null, [
          'success' => 'Image has been deleted'
      ]);
    }
}
