<?php namespace PhotoUpload\Controllers\Web;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use PhotoUpload\Repositories\Image\ImageRepositoryInterface;

class ImagesController extends WebController
{
    /**
     * Image repository.
     *
     * @var \Images\Repositories\ImageRepositoryInterface
     */
    protected $images;

    /**
     * BaseController 
     * 
     * @var PhotoUpload\Controllers\Web
     */
    protected $base;
    
    /**
     * Create a new ImagesController instance.
     *
     * @param \PhotoUpload\Repositories\ImageRepositoryInterface  $images
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
     * Show the single image page.
     *
     * @param  string $slug
     * @return \Response
     */
    public function getShow($slug = null)
    {
        if (is_null($slug)) {
            return $this->base->redirectRoute('home');
        }

        $image = $this->images->getBySlug($slug);

        if (is_null($image)) {
            return $this->base->redirectRoute('home');
        }

        Event::fire('image.view', $image);

        $next = $this->images->getNextImage($image);
        $prev = $this->images->getPreviousImage($image);

        return $this->base
                    ->view('tricks.single', compact('image', 'next', 'prev'));
    }

    /**
     * Handle the liking of a image.
     *
     * @param  string $slug
     * @return \Response
     */
    public function postLike($slug)
    {
        if (! $this->base->request->ajax() || ! $this->base->auth->check()) {
          $this->base->redirectRoute('browse.recent');
        }

        $image = $this->images->getBySlug($slug);
        if (is_null($image)) {
          return $this->base->request->make('error', 404);
        }

        $user = $this->base->auth->user();

        $voted = $image->votes()->whereUserId($user->id)->first();

        if(!$voted) {

          $user = $image->votes()->attach($user->id);
          $image->vote_cache = $image->vote_cache + 1;

        } else {
          $image->votes()->detach($voted->id);
          $image->vote_cache = $image->vote_cache - 1;
        }

        $image->save();

        return Response::make($image->vote_cache, 200);
    }
}
