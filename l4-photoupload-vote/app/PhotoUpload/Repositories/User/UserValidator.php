<?php namespace PhotoUpload\Repositories\User;

use PhotoUpload\Validation\AbstractValidator;
use PhotoUpload\Validation\ValidationInterface;

/**
 * UserUploadValidator 
 * 
 * @uses AbstractValidator
 * @uses ValidationInterface
 * @author Branislav Vladisavljev 
 */
class UserUploadValidator extends AbstractValidator implements ValidationInterface
{
    protected $rules = [
    ];
}
