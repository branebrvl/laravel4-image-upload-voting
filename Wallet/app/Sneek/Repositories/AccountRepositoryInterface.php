<?php namespace Sneek\Repositories;

interface AccountRepositoryInterface
{

    /**
     * Return all accounts in the system
     *
     * @return Illuminate\Support\Collection
     */
    public function all();

    /**
     * Find an account by ID
     *
     * @param  integer $id
     * @return Sneek\Account
     */
    public function findById($id);


    /**
     * Persist an account in storage
     *
     * @param  array $data
     * @return mixed
     */
    public function create($data);

    /**
     * Update a specific account with new data
     *
     * @param integer $id
     * @param array $data
     * @return mixed
     */
    public function update($id, $data);

}