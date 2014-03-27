<?php namespace PhotoUpload\Presenters;

use PhotoUpload\models\User;
use PhotoUpload\models\Image;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\HTML;
use McCool\LaravelAutoPresenter\BasePresenter;

class ImagePresenter extends BasePresenter
{
    /**
     * Cache for whether the user has liked this image.
     *
     * @var bool
     */
    protected $likedByUser = null;

    /**
     * Create a new ImagePresenter instance.
     *
     * @param  \PhotoUpload\models\Image  $image
     * @return void
     */
    public function __construct(Image $image)
    {
        $this->resource = $image;
    }

    /**
     * Get the edit link for this image.
     *
     * @return string
     */
    public function editLink()
    {
        return URL::route('images.edit', [ $this->resource->slug ]);
    }

    /**
     * Get the delete link for this image.
     *
     * @return string
     */
    public function deleteLink()
    {
        return URL::route('images.delete', [ $this->resource->slug ]);
    }

    /**
     * Get a readable created timestamp.
     *
     * @return string
     */
    public function timeago()
    {
        return $this->resource->created_at->diffForHumans();
    }

    /**
     * Returns whether the given user has liked this image.
     *
     * @param  \PhotoUpload\models\User $user
     * @return bool
     */
    public function likedByUser(User $user)
    {
        if (is_null($user)) {
            return false;
        }

        if (is_null($this->likedByUser)) {
            $this->likedByUser = $this->resource
                                      ->votes()
                                      ->where('users.id', $user->id)
                                      ->exists();
        }

        return $this->likedByUser;
    }

    /**
     * Get the meta description for this image.
     *
     * @return string
     */
    public function pageDescription()
    {
        $description = $this->resource->description;
        $maxLength   = 160;
        $description = str_replace('"', '', $description);

        if (strlen($description) > $maxLength) {
            while (strlen($description) + 3 > $maxLength) {
                $description = $this->removeLastWord($description);
            }

            $description .= '...';
        }

        return e($description);
    }

    /**
     * Get the meta title for this image.
     *
     * @return string
     */
    public function pageTitle()
    {
        $title     = $this->resource->title;
        $baseTitle = ' | Render';
        $maxLength = 70;

        if (strlen($title.$baseTitle) > $maxLength) {
            while (strlen($title.$baseTitle) > $maxLength) {
                $title = $this->removeLastWord($title);
            }
        }

        return e($title);
    }

    /**
     * Remove the last word from a given string.
     *
     * @param  string  $string
     * @return string
     */
    protected function removeLastWord($string)
    {
        $split = explode(' ', $string);

        array_pop($split);

        return implode(' ', $split);
    }

    /**
     * Get the tag URI for this image.
     *
     * @return string
     */
    public function tagUri()
    {
        $url = parse_url(route('images.show', $this->resource->slug));

        $output  = 'tag:';
        $output .= $url['host'] . ',';
        $output .= $this->resource->created_at->format('Y-m-d') . ':';
        $output .= $url['path'];

        return $output;
    }
}
