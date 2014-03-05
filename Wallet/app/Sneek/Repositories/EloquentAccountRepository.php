<?php namespace Sneek\Repositories;

use Sneek\Account;

class EloquentAccountRepository implements AccountRepositoryInterface
{
    public function all()
    {
        return Account::all();
    }

    public function findById($id)
    {
        return Account::find($id);
    }

    public function create($data)
    {
        return Account::create($data);
    }

    public function update($id, $data)
    {
        return Account::find($id)->update($data);
    }
}
