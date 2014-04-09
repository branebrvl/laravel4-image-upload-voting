<?php namespace PhotoUpload\Events;

use Illuminate\Session\Store;
use PhotoUpload\Repositories\Image\ImageRepositoryInterface;

class ViewImageHandler
{
  /**
   * Image repository instance.
   *
   */
  protected $images;

  /**
   * Session store instance.
   *
   * @var \Illuminate\Session\Store
   */
  protected $session;

  /**
   * Create a new view image handler instance.
   *
   * @param \PhotoUpload\Repositories\ImageRepositoryInterface\ $image
   * @param  \Illuminate\Session\ $session
   * @return void
   */
  public function __construct(ImageRepositoryInterface $images, Store $session)
  {
    $this->images  = $images;
    $this->session = $session;
  }

  /**
   * Handle the view image event.
   * @return void
   */
  public function handle($image)
  {
    if (! $this->hasViewedImage($image)) {
        $image = $this->images->incrementViews($image);

        $this->storeViewedImage($image);
    }
  }

  /**
   * Determine whether the user has viewed the image.
   *
   * @return bool
   */
  protected function hasViewedImage($image)
  {
    return array_key_exists($image->id, $this->getViewedImages());
  }

  /**
   * Get the users viewed image from the session.
   *
   * @return array
   */
  protected function getViewedImages()
  {
    return $this->session->get('viewed_images', []);
  }

  /**
   * Append the newly viewed image to the session.
   *
   * @return void
   */
  protected function storeViewedImage($image)
  {
    $key = 'viewed_images.' . $image->id;

    $this->session->put($key, time());
  }
}
