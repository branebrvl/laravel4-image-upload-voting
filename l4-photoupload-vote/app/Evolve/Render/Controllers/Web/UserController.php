<?php namespace Evolve\Render\Controllers\Web;

use Illuminate\Support\Facades\Response;
use Evolve\Common\Controllers\BaseController;
use Evolve\Common\Controllers\WebController;
use Evolve\Render\Repositories\Image\ImageRepositoryInterface;
use Evolve\Render\Repositories\User\UserRepositoryInterface;
use Evolve\Render\Services\Image\Upload\Avatar\AvatarUpload;
use Evolve\Render\Repositories\User\UpdateSettingsValidator;

class UserController extends WebController
{
  /**
   * Trick repository.
   *
   * @var \Evolve\Render\Repositories\Image\ImageRepositoryInterface
   */
  protected $images;

  /**
   * User repository.
   *
   * @var \Evolve\Render\Repositories\User\UserRepositoryInterface
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
   * validator 
   * 
   * @var mixed
   */
  protected $validator;

  /**
   * BaseController 
   * 
   * @var \Evolve\Common\Controllers\Web
   */
  protected $base;
  
  /**
   * Create a new UserController instance.
   *
   * @param  \Evolve\Render\Repositories\Image\ImageRepositoryInterface  $images
   * @param  \Evolve\Render\Repositories\User\UserRepositoryInterface  $users
   * @param  \Evolve\Render\Services\Image\Upload\Avatar\AvatarUpload $avatarUpload
   * @param  \Evolve\Render\Repositories\User\UpdateSettingsValidator $validator
   * @param  \Evolve\Common\Controllers\Web\BaseController $base
   *
   * @return void
   */
  public function __construct(
    ImageRepositoryInterface $images,
    UserRepositoryInterface $users, 
    AvatarUpload $avatarUpload, 
    UpdateSettingsValidator $validator,
    BaseController $base
  ) {
    parent::__construct();

    $this->beforeFilter('auth', [ 'except' => 'getPublic' ]);

    $this->user = $base->auth->user();
    $this->images = $images;
    $this->users  = $users;
    $this->avatarUpload = $avatarUpload;
    $this->validator = $validator;
    $this->base = $base;
  }

  /**
   * Show the user's images page.
   *
   * @return \Response
   */
  public function getIndex()
  {
    $images = $this->images->getAllByUser($this->user, 12);

    return $this->base
                ->view('user.profile', compact('images'));
  }

  /**
   * Show the settings page.
   *
   * @return \Response
   */
  public function getSettings()
  {
    return $this->base
                ->view('user.settings');
  }

  /**
   * Show the favorited images page.
   *
   * @return \Response
   */
  public function getFavorites()
  {
    $images = $this->images->getAllFavorites($this->user);

    return $this->base->view('user.favorites', compact('images'));
  }

  /**
   * Handle the settings form.
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postSettings()
  {
    $input = $this->base
                  ->request
                  ->only(['username', 'email', 'password', 'password_confirmation', 'avatar']);

    if ($this->validator->with($input)->fails()) 
    {
      return $this->base
                  ->redirectBack([ 'errors' => $this->validator->errors() ]);
    }

    $this->users->updateSettings($this->user, $input);

    return $this->base
                ->redirectRoute('user.settings', [], [ 'settings_updated' => true ]);
  }

  /**
   * Handle the avatar upload.
   *
   * @return \Illuminate\Http\Response
   */
  public function postAvatar()
  {
    $upload = $this->avatarUpload->handle($this->base->request->file('filedata'));

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
    $user = $this->users->requireByUsername($username);
    $images = $this->images->getAllByUser($user);

    return $this->base
                ->view('user.public', compact('user', 'images'));
  }
}
