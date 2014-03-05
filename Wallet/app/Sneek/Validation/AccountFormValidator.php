<?php namespace Sneek\Validation;

class AccountFormValidator extends AbstractValidator implements ValidationInterface
{
    protected $rules = [
        'name' => 'required',
        'balance' => 'required|numeric',
    ];
}
