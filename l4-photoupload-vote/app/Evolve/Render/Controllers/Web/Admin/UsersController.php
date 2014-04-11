<?php namespace Evolve\Render\Controllers\Web\Admin;

use Carbon\Carbon;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Response;
use Evolve\Common\Controllers\BaseController;
use Evolve\Common\Controllers\WebController;
use Evolve\Render\Repositories\User\UserRepositoryInterface;
use Evolve\Render\Repositories\User\InvitationValidator;

class UsersController extends WebController
{
  /**
   * User repository.
   *
   * @var \Evolve\Render\Repositories\User\UserRepositories
   */
  protected $users;

  /**
   * validator 
   * 
   * @var \Evolve\Render\Repositories\User\InvitationValidator
   */
  protected $validator;

  /**
   * BaseController 
   * 
   * @var Evolve\Common\Controllers\Web\BaseController
   */
  protected $base;

  /**
   * Create a new UsersController instance.
   *
   * @param  \Evolve\Render\Repositories\User\UserRepositories $users
   * @param  \Evolve\Render\Repositories\User\InvitationValidator $validator
   * @param  \Evolve\Common\Controllers\Web\BaseController
   * @return void
   */
  public function __construct(
    UserRepositoryInterface $users,
    InvitationValidator $validator,
    BaseController $base
  ) {
    parent::__construct();

    $this->users = $users;
    $this->validator = $validator;
    $this->base = $base;
  }

  /**
   * Show the users index page.
   *
   * @return \Response
   */
  public function getIndex()
  {
    $users = $this->users->getAllPaginated();

    return $this->base
                ->view('admin.users.list', compact('users'));
  }

  /**
   * Handle the blocking of a user.
   *
   * @param  string $id
   * @return \Response
   */
  public function postBlock()
  {
    if (! $this->base->request->ajax() || ! $this->base->auth->check()) 
    {
      $this->base->redirectTo('admin/users');
    }

    $data = $this->base->request->only(['id']);

    $user = $this->users->getById($data['id']);

    if (is_null($user)) 
    {
      return Response::make('error', 404);
    }

    if(!$user->blocked_at) 
    {
      $user->blocked_at = (string)Carbon::now();
    } else {
      $user->blocked_at = null;
    }

    $user->save();

    return Response::make($user->blocked_at, 200);
  }

  /**
   * Handle a POST request to invite a user to the app.
   *
   * @return \Illuminate\Http\RedirectResponse
   */
  public function postInvite()
  {
    $data = $this->base
                  ->request
                  ->only(['email', 'username']);
    
    if ($this->validator->with($data)->fails()) 
    {
      return $this->base
                  ->redirectTo('admin/users')
                  ->withErrors($this->validator->errors())
                  ->withInput();
    }

    $this->users->store([
      'email' => $data['email'],
      'password' => 'changeme!',
      'username' => $data['username']
    ]);

    $result = Password::remind(['email' => $data['email']], function ($message, $user) {
      $message->subject('You are invited to Render!');
    });

    switch ($result) {
      case Password::INVALID_USER:
        return $this->base
                    ->redirectTo('admin/users', [
                                  'error' => 'We can\'t find a user with the e-mail address'
                                ]);

      case Password::REMINDER_SENT:
        return $this->base
                    ->redirectTo('admin/users', [
                                  'user_created' => true
                                ]);
    }
  }
  /**
   * Delete a user from the database.
   *
   * @param  mixed $id
   * @return \Illuminate\Http\RedirectResponse
   */
  public function getDelete($id)
  {
    $this->users->delete($id);

    return $this->base
                ->redirectTo('admin/users');
  }
}
