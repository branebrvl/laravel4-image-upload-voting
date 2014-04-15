<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Event\SuiteEvent,
    Behat\Behat\Event\ScenarioEvent,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Behat\MinkExtension\Context\MinkContext;
use Behat\Mink\WebAssert;

/**
 * Features context.
 */
class FeatureContext extends MinkContext
{
    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        // Initialize your context here
    }

    /**
     * @BeforeSuite
     */
     public static function prepare(SuiteEvent $event)
     {
        $unitTesting = true;

        //you can set up a separate db for acceptance testing only
        $testEnvironment = 'testing';

        return require __DIR__.'/../../../../bootstrap/start.php';
         // prepare system for test suite
         // before it runs

        //run migration, seed db
     }

     /**
      * @AfterScenario @database
      */
     public function cleanDB(ScenarioEvent $event)
     {
         // clean database after scenarios,
         // tagged with @database
     }

    /** Click on the element with the provided xpath query
     *
     * @When /^I click on the element with xpath "([^"]*)"$/
     */
    public function iClickOnTheElementWithXPath($xpath)
    {
        $session = $this->getSession(); // get the mink session
        $element = $session->getPage()->find(
            'xpath',
            $session->getSelectorsHandler()->selectorToXpath('xpath', $xpath)
        ); // runs the actual query and returns the element

        // errors must not pass silently
        if (null === $element) {
            throw new \InvalidArgumentException(sprintf('Could not evaluate XPath: "%s"', $xpath));
        }

        // ok, let's click on it
        $element->click();

    }

    /** Click on the element with the provided xpath query
     *
     * @When /^(?:|I )click on the element "([^"]*)"$/
     */
    public function iClickOnTheElement($locator)
    {
        $session = $this->getSession(); // get the mink session
        $element = $session->getPage()->find('css', $locator); // runs the actual query and returns the element

        // errors must not pass silently
        if (null === $element) {
            throw new \InvalidArgumentException(sprintf('Could not evaluate CSS selector: "%s"', $locator));
        }

        // ok, let's click on it
        $element->click();
    }

    /**
     * @Then /^I should see the modal "([^"]*)"$/
     */
    public function iShouldSeeTheModal($title)
    {
      $this->getSession()->wait(5000, '($(\'#add_tag\').css(\'display\') === \'block\')');
      $this->assertElementContainsText('.modal-header', $title);
    }

    /**
     * @Then /^I should see the dropdown$/
     */
    public function iShouldSeeTheDropdown()
    {
      $this->getSession()->wait(5000, '($(\'.navbar-collapse\').css(\'height\') !== \'auto\')');
      $this->assertElementContains('.in', 'tags');
    }

    /**
     * @Given /^I am logged in$/
     */
    public function iAmLoggedIn()
    {
        $this->visit('/login');
        $this->fillField('username', 'branislav.vladisavljev@evolvemediallc.com');
        $this->fillField('password', 'changeme');
        $this->pressButton('Login');
        $this->assertPageNotContainsText('E-mail or password was incorrect, please try again');
    }

    /**
     * @Given /^I press enter$/
     */
    public function iPressEnter()
    {
      $this->getSession()->evaluateScript('$(\'input[value="search"]\').toggle();');
      $this->pressButton('search');
    }
}
