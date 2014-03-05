<?php

class EloquentAccountRepositoryTest extends TestCase
{

    /**
     * @var Sneek\Repositories\EloquentAccountRepository
     */
    protected $repo;

    public function setUp()
    {
        parent::setUp();

        Artisan::call('migrate');

        $this->repo = new Sneek\Repositories\EloquentAccountRepository;
    }

    public function tearDown()
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }

    /**
     * @test
     */
    public function it_creates_account()
    {
        $this->repo->create($data = $this->getFakeAccount());

        $account = DB::table('accounts')->first();

        $this->assertEquals('HSBC Main', $account->name);
        $this->assertEquals(10000, $account->balance);
    }

    /**
     * @test
     */
    public function it_fetches_account_by_id()
    {
        $this->repo->create($data = $this->getFakeAccount());

        $account = $this->repo->findById(1);

        $this->assertEquals('HSBC Main', $account->name);
        $this->assertEquals(10000, $account->balance);
    }

    /**
     * @test
     */
    public function it_should_return_all_accounts_in_a_collection()
    {
        $this->repo->create($data = $this->getFakeAccount());
        $this->repo->create($data = $this->getFakeAccount());
        $this->repo->create($data = $this->getFakeAccount());

        $accounts = $this->repo->all();

        $this->assertCount(3, $accounts);
        $this->assertInstanceOf('Illuminate\Support\Collection', $accounts);
    }

    /**
     * @test
     */
    public function it_should_update_an_account()
    {
        $this->repo->create($data = $this->getFakeAccount());

        $this->repo->update(1, ['name' => 'Halifax']);

        $account = $this->repo->findById(1);

        $this->assertEquals('Halifax', $account->name);
    }



    public function getFakeAccount()
    {
        return [
            'name' => 'HSBC Main',
            'balance' => 10000
        ];
    }

}
