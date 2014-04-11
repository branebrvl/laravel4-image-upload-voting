<?php namespace Evolve\Render\Controllers\Web\Admin;

use Evolve\Common\Controllers\BaseController;
use Evolve\Common\Controllers\WebController;
use Evolve\Render\Repositories\Tag\TagRepositoryInterface;
use Evolve\Render\Repositories\Tag\TagValidator;

class TagsController extends WebController
{
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
   * @param  \Evolve\Render\Repositories\Tag\TagRepositoyInterface  $tags
   * @param  \Evolve\Render\Repositories\Tag\TagValidator $validator
   * @param  \Evolve\Common\Controllers\Web\BaseController
   *
   * @return void
   */
  public function __construct(
    TagRepositoryInterface $tags, 
    TagValidator $validator,
    BaseController $base
  ){
    parent::__construct();

    $this->tags = $tags;
    $this->validator = $validator;
    $this->base = $base;
  }

  /**
   * Show the tags index page.
   *
   * @return \Response
   */
  public function getIndex()
  {
    $tags = $this->tags->getAll();

    return $this->base
                ->view('admin.tags.list', compact('tags'));
  }

  /**
   * Delete a tag from the database.
   *
   * @param  mixed $id
   * @return \Illuminate\Http\RedirectResponse
   */
  public function getDelete($id)
  {
    $this->tags->delete($id);

    return $this->base
                ->redirectRoute('admin.tags.index');
  }

  /**
   * Show the tag edit form.
   *
   * @param  mixed $id
   * @return \Response
   */
  public function getView($id)
  {
    $tag = $this->tags->getById($id);

    return $this->base
                ->view('admin.tags.edit', compact('tag'));
  }

  /**
   * Handle the creation of a tag.
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postIndex()
  {
    $input = $this->base
                  ->request
                  ->only(['name']);

    if ($this->validator->with($input)->fails()) 
    {
      return $this->base
                  ->redirectRoute('admin.tags.index')
                  ->withErrors($this->validator->errors())
                  ->withInput();
    }

    $tag = $this->tags->store($input);

    return $this->base
                ->redirectRoute('admin.tags.index');
  }

  /**
   * Handle the editting of a tag.
   *
   * @param  mixed $id
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postView($id)
  {
    $input = $this->base
                  ->request
                  ->only(['name']);

    if ($this->validator->with($input)->fails()) 
    {
      return $this->base
                  ->redirectRoute('admin.tags.view', $id)
                  ->withErrors($this->validator->errors())
                  ->withInput();
    }

    $tag = $this->tags->update($id, $input);

    return $this->base
                ->redirectRoute('admin.tags.index', $id);
  }
}
