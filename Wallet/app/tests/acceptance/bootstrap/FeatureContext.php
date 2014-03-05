<?php

use Behat\Behat\Context\BehatContext;

/**
 * Features context.
 */
final class FeatureContext extends BehatContext
{
    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        $this->useContext('subcontext_alias', new AccountContext());
    }

    /**
     * @beforeSuite
     */
    public static function up()
    {
        /**
         * @var $app Illuminate\Foundation\Application
         */
        $app = require_once __DIR__ . '/../../../../bootstrap/start.php';
        $app->boot();

        Artisan::call('migrate:refresh');
    }

    /**
     * @afterSuite
     */
    public static function down()
    {
    }

}
