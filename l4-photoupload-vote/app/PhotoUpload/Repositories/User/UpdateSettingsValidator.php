<?php namespace PhotoUpload\Repositories\User;

use Illuminate\Config;
use Illuminate\Config\Repository; 
use Illuminate\Validation\Factory;
use Illuminate\Support\Facades\Auth;
use PhotoUpload\Validation\AbstractValidator;
use PhotoUpload\Validation\ValidationInterface;

/**
 * RegistrationValidator
 * 
 * @uses AbstractValidator
 * @uses ValidationInterface
 */
class UpdateSettingsValidator extends AbstractValidator implements ValidationInterface
{
    protected $rules = [
        'username' => 'required|min:4|alpha_num',
        'password' => 'required|min:6'  
    ];

    /**
     * Array of custom validation messages.
     *
     * @var array
     */
    protected $messages = [
        'not_in' => 'The selected username is reserved, please try a different username.'
    ];
        
    /**
     * Config repository instance.
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * Create a new RegistrationForm instance.
     *
     * @param  \Illuminate\Config\Repository  $config
     * @return void
     */
    public function __construct(Factory $factory, Repository $config)
    {
        parent::__construct($factory);

        $this->config = $config;
    }

    /**
     * Get the prepared validation rules.
     *
     * @return array
     */
    protected function getPreparedRules()
    {
        $forbidden = implode(',', $this->config->get('forbidden_usernames'));
        $userId    = Auth::user()->id;

        $this->rules['username'] .= '|not_in:' . $forbidden;
        $this->rules['username'] .= '|unique:users,username,' . $userId;
        
        return $this->rules;
    } 
}
