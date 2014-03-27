<?php

namespace Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use PhotoUpload\Repositories\ImageRepositoryInterface;

class ImagesController extends BaseController
{
    /**
     * Image repository.
     *
     * @var \Images\Repositories\ImageRepositoryInterface
     */
    protected $images;

    /**
     * Create a new ImagesController instance.
     *
     * @param \PhotoUpload\Repositories\ImageRepositoryInterface  $images
     * @return void
     */
    public function __construct(ImageRepositoryInterface $images)
    {
        parent::__construct();

        $this->images = $images;
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
            return $this->redirectRoute('home');
        }

        $image = $this->images->findBySlug($slug);

        if (is_null($image)) {
            return $this->redirectRoute('home');
        }

        Event::fire('image.view', $image);

        $next = $this->images->findNextImage($image);
        $prev = $this->images->findPreviousImage($image);

        $this->view('images.single', compact('image', 'next', 'prev'));
    }

    /**
     * Handle the liking of a image.
     *
     * @param  string $slug
     * @return \Response
     */
    public function postLike($slug)
    {
        if (! Request::ajax() || ! Auth::check()) {
            $this->redirectRoute('browse.recent');
        }

        $image = $this->images->findBySlug($slug);

        if (is_null($image)) {
            return Response::make('error', 404);
        }

        $user = Auth::user();

        $voted = $image->votes()->whereUserId($user->id)->first();

        if(!$voted) {

            $user = $image->votes()->attach($user->id, [
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime
            ]);
            $image->vote_cache = $image->vote_cache + 1;

        } else {
            $image->votes()->detach($voted->id);
            $image->vote_cache = $image->vote_cache - 1;
        }

        $image->save();

        return Response::make($image->vote_cache, 200);
    }
}
