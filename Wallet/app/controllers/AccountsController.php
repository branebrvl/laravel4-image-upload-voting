<?php

use Sneek\Repositories\AccountRepositoryInterface as AccountRepo;
use Sneek\Validation\AccountFormValidator as AccountValidator;

class AccountsController extends BaseController
{

    /**
     * Account repository
     *
     * @var Sneek\Repositories\AccountRepositoriesInterface
     */
    protected $repo;

    /**
     * Account form validator
     *
     * @var Sneek\Validation\AccountFormValidator
     */
    protected $validator;

    public function __construct(AccountRepo $repo, AccountValidator $validator)
    {
        $this->repo = $repo;
        $this->validator = $validator;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$accounts = $this->repo->all();

        return View::make('accounts.index', compact('accounts'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('accounts.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        if ($this->validator->with(Input::all())->passes())
        {
            $this->repo->create(Input::all());

		    return Redirect::route('accounts.index')
                    ->withMessage('Account created successfully')
                    ->withMessageType('success');
        }

        return Redirect::route('accounts.create')
                        ->withInput()
                        ->withMessage('There was a problem creating the account')
                        ->withErrors($this->validator->errors());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $account = $this->repo->findById($id);

		return View::make('accounts.edit', compact('account'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        if ($this->validator->with(Input::all())->passes())
        {
            $this->repo->update($id, Input::all());

            return Redirect::route('accounts.index')->withMessage('Account updated successfully');
        }

        return Redirect::route('accounts.edit', $id)
                    ->withInput()
                    ->withMessage('There was a problem updating the account')
                    ->withErrors($this->validator->errors());
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
