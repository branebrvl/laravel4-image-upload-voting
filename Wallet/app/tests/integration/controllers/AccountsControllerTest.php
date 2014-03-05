<?php

class AccountsControllerTest extends TestCase
{

    /**
     * @var Mockery\Mock
     */
    protected $repo;

    /**
     * @var Mockery\Mock
     */
    protected $account;

    /**
     * @var Mockery\Mock
     */
    protected $validator;

    /**
     * @var Illuminate\Support\Collection
     */
    protected $collection;

    public function setUp()
    {
        parent::setUp();

        $this->repo = $this->mock('Sneek\Repositories\AccountRepositoryInterface');
        $this->validator = $this->mock('Sneek\Validation\AccountFormValidator');
        $this->account = Way\Tests\Factory::make('Sneek\Account');
        $this->collection = Mockery::mock('Illuminate\Support\Collection')->shouldDeferMissing();
    }

    public function mock($class)
    {
        $mock = Mockery::mock($class);
        $this->app->instance($class, $mock);
        return $mock;
    }

    /**
     * @test
     */
    public function it_displays_all_accounts()
    {
        $this->repo->shouldReceive('all')->once()->andReturn($this->collection);

        $this->call('GET', 'accounts');

        $this->assertViewHas('accounts');
        $this->assertResponseOk();
    }

    /**
     * @test
     */
    public function it_displays_new_account_form()
    {
        $this->route('GET', 'accounts.create');

        $this->assertResponseOk();
        $this->assertIsView();
    }

    /**
     * @test
     */
    public function it_stores_new_account()
    {
        $this->repo->shouldReceive('create')->once();
        $this->validate(true);

        $account = ['name' => 'HSBC', 'balance' => 100];

        $this->route('POST', 'accounts.store', $account);

        $this->assertRedirectedToRoute('accounts.index');
        $this->assertSessionHas('message');
    }

    /**
     * @test
     */
    public function it_does_not_store_account()
    {
        $account = ['name' => 'HSBC'];
        $this->validate(false);

        $this->route('POST', 'accounts.store', $account);

        $this->assertRedirectedToRoute('accounts.create');
    }

    /**
     * @test
     */
    public function it_displays_edit_form()
    {
        $this->repo->shouldReceive('findById')->with(1)->once()->andReturn($this->account);

        $this->route('GET', 'accounts.edit', [1]);

        $this->assertIsView();
        $this->assertResponseOk();
        $this->assertViewHas('account');
    }

    /**
     * @test
     */
    public function it_updates_the_account()
    {
        $this->repo->shouldReceive('update')->once();
        $this->validate(true);

        $this->route('PUT', 'accounts.update', [1]);

        $this->assertRedirectedToRoute('accounts.index');
        $this->assertSessionHas('message');
    }

    /**
     * @test
     */
    public function it_fails_to_update_the_account()
    {
        $this->validate(false);

        $this->route('PUT', 'accounts.update', [1]);

        $this->assertRedirectedToRoute('accounts.edit', [1]);
        $this->assertSessionHasErrors();
    }

    /**
     * @param $bool
     */
    public function validate($bool)
    {
        $this->validator->shouldReceive('passes')->once()->andReturn($bool);
    }
}
