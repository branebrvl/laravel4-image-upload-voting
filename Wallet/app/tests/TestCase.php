<?php

use Illuminate\View\View;

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	/**
	 * Creates the application.
	 *
	 * @return \Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication()
	{
		$unitTesting = true;

		$testEnvironment = 'testing';

		return require __DIR__.'/../../bootstrap/start.php';
	}

    public function assertIsView()
    {
        $response = $this->client->getResponse()->original;

        if ( ! $response instanceof View)
        {
            return $this->assertTrue(false, 'The response was not a view.');
        }

        return $this->assertTrue(true);
    }

    public function tearDown()
    {
        Mockery::close();
    }

}
