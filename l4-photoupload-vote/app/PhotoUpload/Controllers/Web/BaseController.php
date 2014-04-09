<?php namespace PhotoUpload\Controllers\Web;

class BaseController
{
    /**
     * Input data and HTTP Request methods 
     * 
     * @var \Illuminate\Http\Request
     */
    public $request;

    /**
     * Authentication service  
     * 
     * @var Illuminate\Auth\AuthManager
     */
    public $auth;

    /**
     * Redirector instance
     * 
     * @var Illuminate\Routing\Redirector
     */
    public $redirect;

    /**
     * View environment instance
     * 
     * @var /Illuminate\View\Environment
     */
    public $view;

    /**
     * Create a new BaseController instance.
     *
     * @return void
     */
    public function __construct(
      \Illuminate\Http\Request $request,
      \Illuminate\Auth\AuthManager $auth,
      \Illuminate\Routing\Redirector $redirect,
      \Illuminate\View\Environment $view
    ) {
        $this->request = $request;
        $this->auth = $auth;
        $this->redirect = $redirect;
        $this->view = $view;
    }

    /**
     * Set the specified view as content on the layout.
     *
     * @param  string  $path
     * @param  array  $data
     * @return Illuminate\View\View
     */
    public function view($path, $data = [])
    {
        return $this->view->make($path, $data);
    }


    /**
     * Return the Request instance.  
     * 
     * 
     * @return \Illuminate\Http\Request
     */
    public function request()
    {
      return $this->request;
    }

    /**
     * Redirect to the specified named route.
     *
     * @param  string  $route
     * @param  array  $params
     * @param  array  $data
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectRoute($route, $params = [], $data = [])
    {
        return $this->redirect->route($route, $params)->with($data);
    }

    /**
     * Redirect to the specified named route.
     *
     * @param  string  $path
     * @param  array  $data
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectTo($path, $data = [])
    {
        return $this->redirect->to($path)->with($data);
    }

    /**
     * Redirect back with old input and the specified data.
     *
     * @param  array $data
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectBack($data = [])
    {
        return $this->redirect->back()->withInput()->with($data);
    }

    /**
     * Redirect a logged in user to the previously intended url.
     *
     * @param  mixed $default
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectIntended($default = null)
    {
        return $this->redirect->intended($default);
    }
}
