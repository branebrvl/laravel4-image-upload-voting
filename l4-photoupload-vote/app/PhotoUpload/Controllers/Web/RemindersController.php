<?php namespace PhotoUpload\Controllers\Web;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Password;

class RemindersController extends WebController
{
    /**
     * Create a new RemindersController instance.
     *
     * @param \PhotoUpload\Controllers\Web $base
     * @return void
     */   
    function __construct(
      BaseController $base
    ) {   
      parent::__construct();

      $this->base = $base;
    }   
    /**
     * Display the password reminder view.
     *
     * @return \Response
     */
    public function getRemind()
    {
      return $this->base->view('password.remind');
    }

    /**
     * Handle a POST request to remind a user of their password.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRemind()
    {
        $result = Password::remind($this->base->request->only('email'), function ($message, $user) {
            $message->subject('Your Password Reminder for Render');
        });

        switch ($result) {
            case Password::INVALID_USER:
              return $this->base
                          ->redirect
                          ->back()
                          ->with('error', Lang::get($result));

            case Password::REMINDER_SENT:
              return $this->base
                          ->redirect
                          ->back()
                          ->with('success', true);
        }
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param  string  $token
     * @return \Response
     */
    public function getReset($token = null)
    {
        if (is_null($token)) {
            App::abort(404);
        }

        $this->base
             ->view('password.reset', [ 'token' => $token ]);
    }

    /**
     * Handle a POST request to reset a user's password.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postReset()
    {
        $credentials = Input::only([
            'email',
            'password',
            'password_confirmation',
            'token'
        ]);

        $response = Password::reset($credentials, function ($user, $password) {
            $user->password = $password;
            $user->save();
        });

        switch ($response) {
            case Password::INVALID_PASSWORD:
            case Password::INVALID_TOKEN:
            case Password::INVALID_USER:
              return $this->base
                          ->redirect
                          ->back()
                          ->with('error', Lang::get($response));

            case Password::PASSWORD_RESET:
              return $this->base
                          ->redirect
                          ->to('login')
                          ->with('password_reset', true);
        }
    }
}
