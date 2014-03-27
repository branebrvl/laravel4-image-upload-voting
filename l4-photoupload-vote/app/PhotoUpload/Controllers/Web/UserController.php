<?php namespace PhotoUpload\Controllers\Web;

use ImageUpload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use PhotoUpload\Repositories\Image\ImageRepositoryInterface;
use PhotoUpload\Repositories\User\UserRepositoryInterface;

class UserController extends BaseController
{
    /**
     * Trick repository.
     *
     * @var \PhotoUpload\Repositories\Image\ImageRepositoryInterface
     */
    protected $images;

    /**
     * User repository.
     *
     * @var \PhotoUpload\Repositories\User\UserRepositoryInterface
     */
    protected $users;

    /**
     * The currently authenticated user.
     *
     * @var \User
     */
    protected $user;

    /**
     * avatarUpload 
     * 
     * @var mixed
     */
    protected $avatarUpload;

    /**
     * Create a new UserController instance.
     *
     * @param \PhotoUpload\Repositories\Image\ImageRepositoryInterface  $images
     * @param \PhotoUpload\Repositories\User\UserRepositoryInterface  $users
     */
    public function __construct(ImageRepositoryInterface $images, UserRepositoryInterface $users, AvatarUpload $avatarUpload)
    {
        parent::__construct();

        $this->beforeFilter('auth', [ 'except' => 'getPublic' ]);

        $this->user   = Auth::user();
        $this->images = $images;
        $this->users  = $users;
        $this->avatarUpload = $avatarUpload;
    }

    /**
     * Show the user's images page.
     *
     * @return \Response
     */
    public function getIndex()
    {
        $images = $this->images->getAllByUser($this->user, 12);

        $this->view('user.profile', compact('images'));
    }

    /**
     * Show the settings page.
     *
     * @return \Response
     */
    public function getSettings()
    {
        $this->view('user.settings');
    }

    /**
     * Show the favorited images page.
     *
     * @return \Response
     */
    public function getFavorites()
    {
        $images = $this->images->getAllFavorites($this->user);

        $this->view('user.favorites', compact('images'));
    }

    /**
     * Handle the settings form.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSettings()
    {
        $form = $this->users->getSettingsForm();

        if (! $form->isValid()) {
            return $this->redirectBack([ 'errors' => $form->getErrors() ]);
        }

        $this->users->updateSettings($this->user, Input::all());

        return $this->redirectRoute('user.settings', [], [ 'settings_updated' => true ]);
    }

    /**
     * Handle the avatar upload.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAvatar()
    {
        $upload = $this->avatarUpload->handle(Input::file('filedata'));

        if ($upload->succeeds()) {
            return Response::json($upload->getJsonBody(), 200);
        }

        return Response::json('error', 400);
    }

    /**
     * Show the user's public profile page.
     *
     * @param  string  $username
     * @return \Response
     */
    public function getPublic($username)
    {
        $user   = $this->users->requireByUsername($username);
        $images = $this->images->getAllForUser($user);

        $this->view('user.public', compact('user', 'images'));
    }
}
