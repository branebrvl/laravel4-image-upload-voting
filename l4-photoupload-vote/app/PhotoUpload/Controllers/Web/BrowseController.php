<?php namespace PhotoUpload\Controllers\Web;

use PhotoUpload\Repositories\Image\ImageRepositoryInterface;

class BrowseController extends BaseController
{

    /**
     * Image repository.
     *
     */
    protected $image;

    /**
     * Create a new BrowseController instance.
     *
     * @return void
     */
    public function __construct( ImageRepositoryInterface $image) 
    {
        $this->image = $image;
    }

    /**
     * Show the browse recent image page.
     *
     * @return \Response
     */
    public function getBrowseRecent()
    {
        $image = $this->image->findMostRecent();

        $type      = 'Recent';
        $pageTitle = 'Browsing Most Recent Photos';

        $this->view('browse.index', compact('image', 'type', 'pageTitle'));
    }

    /**
     * Show the browse popular image page.
     *
     * @return \Response
     */
    public function getBrowsePopular()
    {
        $image = $this->image->findMostPopular();

        $type      = 'Popular';
        $pageTitle = 'Browsing Most Popular Photos';

        $this->view('browse.index', compact('image', 'type', 'pageTitle'));
    }

    /**
     * Show the browse most commented image page.
     *
     * @return \Response
     */
    public function getBrowseComments()
    {
        $image = $this->image->findMostCommented();

        $type      = 'Most commented';
        $pageTitle = 'Browsing Most Commented Photos';

        $this->view('browse.index', compact('image', 'type', 'pageTitle'));
    }
}
