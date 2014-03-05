<?php namespace Sneek;

class Account extends \Eloquent
{
    protected $table = 'accounts';

    protected $fillable = ['name', 'balance'];
}