<?php namespace PhotoUpload\Controllers\Web;

use PhotoUpload\Repositories\User\UserRepositoryInterface;
use PhotoUpload\Repositories\User\RegistrationValidator;

class AuthController extends WebController
{
    /**
     * User Repository.
     *
     * @var \PhotoUpload\Repositories\User\UserRepositoryInterface
     */
    protected $user;


    /**
     * User Validator 
     * 
     * @var PhotoUpload\Controllers\Web
     */
    protected $base;

    protected $validator;

    /**
     * Create a new AuthController instance.
     *
     * @param  \PhotoUpload\Repositories\User\UserRepositoryInterface $user
     * @param  \PhotoUpload\Repositories\User\RegistrationValidator $validator
     * @return void
     */
    public function __construct(
      UserRepositoryInterface $user,
      RegistrationValidator $validator,
      BaseController $base
    ) {
      parent::__construct();

      $this->user = $user;
      $this->validator = $validator;
      $this->base = $base;
    }

    /**
     * Show login form.
     *
     * @return \Response
     */
    public function getLogin()
    {
      return $this->base
                  ->view('home.login');
    }

    /**
     * Post login form.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin()
    {
      $credentials = $this->base
                            ->request
                            ->only([ 'username', 'password' ]);

      $remember = $this->base
                         ->request
                         ->get('remember', false);

        if (str_contains($credentials['username'], '@')) 
        {
            $credentials['email'] = $credentials['username'];
            unset($credentials['username']);
        }

        if ($this->base->auth->attempt($credentials, $remember)) 
        {
            return $this->base->redirectIntended(route('user.index'));
        }

        return $this->base->redirectBack([ 'login_errors' => true ]);
    }

    /**
     * Show registration form.
     *
     * @return \Response
     */
    public function getRegister()
    {
      return $this->base
                  ->view('home.register');
    }

    /**
     * Post registration form.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegister()
    {
      $input = $this->base
                      ->request
                      ->only(['username', 'email', 'password', 'password_confirmation']);

        if ($this->validator->with($input)->fails()) 
        {
            return $this->base->redirectBack([ 'errors' => $this->validator->errors() ]);
        }

        if ($user = $this->user->store($input)) 
        {
            $this->base->auth->login($user);
            return $this->base->redirectRoute('user.index', [], [ 'first_use' => true ]);
        }

        return $this->base->redirectRoute('home');
    }

    /**
     * Logout the user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout()
    {
        $this->base->auth->logout();

        return $this->base
                    ->redirectRoute('auth.login', [], [ 'logout_message' => true ]);
    }
}
