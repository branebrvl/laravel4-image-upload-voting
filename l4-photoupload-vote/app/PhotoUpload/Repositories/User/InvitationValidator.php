<?php namespace PhotoUpload\Repositories\User;

use PhotoUpload\Validation\AbstractValidator;
use PhotoUpload\Validation\ValidationInterface;

/**
 * InvitationValidator
 * 
 * @uses AbstractValidator
 * @uses ValidationInterface
 */
class InvitationValidator extends AbstractValidator implements ValidationInterface
{
    protected $rules = [
        'username' => 'required|min:4|alpha_num|unique:users,username',
        'email' => 'required|email|min:5|unique:users',
    ];
}
