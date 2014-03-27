<?php namespace PhotoUpload\Controllers\Web;

// use Github;
// use GithubProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use PhotoUpload\Repositories\User\UserRepositoryInterface;
use PhotoUpload\Repositories\User\RegistrationValidator;

class AuthController extends BaseController
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
     * @var mixed
     */
    protected $validator;

    /**
     * Create a new AuthController instance.
     *
     * @param  \PhotoUpload\Repositories\User\UserRepositoryInterface $user
     * @param  \PhotoUpload\Repositories\User\RegistrationValidator $validator
     * @return void
     */
    public function __construct(UserRepositoryInterface $user, RegistrationValidator $validator)
    {
        parent::__construct();

        $this->user = $user;
        $this->validator = $validator;
    }

    /**
     * Show login form.
     *
     * @return \Response
     */
    public function getLogin()
    {
        $this->view('home.login');
    }

    /**
     * Post login form.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin()
    {
        $credentials = Input::only([ 'username', 'password' ]);
        $remember    = Input::get('remember', false);

        if (str_contains($credentials['username'], '@')) 
        {
            $credentials['email'] = $credentials['username'];
            unset($credentials['username']);
        }

        if (Auth::attempt($credentials, $remember)) 
        {
            return $this->redirectIntended(route('user.index'));
        }

        return $this->redirectBack([ 'login_errors' => true ]);
    }

    /**
     * Show registration form.
     *
     * @return \Response
     */
    public function getRegister()
    {
        $this->view('home.register');
    }

    /**
     * Post registration form.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegister()
    {
        $input = Input::only(['username', 'email', 'password', 'password_confirmation']);

        if ($this->validator->with($input)->fails()) 
        {
            return $this->redirectBack([ 'errors' => $this->validator->errors() ]);
        }

        if ($user = $this->user->store($input)) 
        {
            Auth::login($user);
            return $this->redirectRoute('user.index', [], [ 'first_use' => true ]);
        }

        return $this->redirectRoute('home');
    }

    /**
     * Handle Github login.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    // public function getLoginWithGithub()
    // {
    //     if (! Input::has('code')) {
    //         Session::keep([ 'url' ]);
    //         GithubProvider::authorize();
    //     } else {
    //         try {
    //             $user = Github::register(Input::get('code'));
    //             Auth::login($user);
    //
    //             if (Session::get('password_required')) {
    //                 return $this->redirectRoute('user.settings', [], [
    //                     'update_password' => true
    //                 ]);
    //             }
    //
    //             return $this->redirectIntended(route('user.index'));
    //         } catch (GithubEmailNotVerifiedException $e) {
    //             return $this->redirectRoute('auth.register', [
    //                 'github_email_not_verified' => true
    //             ]);
    //         }
    //     }
    // }

    /**
     * Logout the user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout()
    {
        Auth::logout();

        return $this->redirectRoute('auth.login', [], [ 'logout_message' => true ]);
    }
}
