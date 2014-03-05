<?php

use Behat\Behat\Exception\PendingException;
use Behat\MinkExtension\Context\MinkContext;

class AccountContext extends MinkContext
{
    /**
     * @Given /^I submit the new account form incorrectly$/
     */
    public function submit_form_new_account_form_incorrectly()
    {
        $this->pressButton('Create Account');
    }

    /**
     * @Given /^I submit the new account form correctly$/
     */
    public function submit_new_account_form_correctly()
    {
        $this->fillForm(['name' => 'HSBC', 'balance' => 100]);
        $this->pressButton('Create Account');
    }

    /**
     * @Given /^I submit the edit account form correctly$/
     */
    public function submit_edit_form_correctly()
    {
        $this->fillForm(['name' => 'My Personal Account', 'balance' => 100]);
        $this->pressButton('Update Account');
    }

    /**
     * @Given /^I submit the edit account form incorrectly$/
     */
    public function submit_edit_form_incorrectly()
    {
        $this->fillForm(['name' => '', 'balance' => 100]);
        $this->pressButton('Update Account');
    }

    /**
     * @param array $acc
     */
    public function fillForm($acc = [])
    {
        $acc = array_merge([
            'name' => '',
            'balance' => null,
        ], $acc);

        $this->fillField('name', $acc['name']);
        $this->fillField('balance', $acc['balance']);
    }

    /**
     * @Given /^there is (\d+) account$/
     */
    public function thereIsAccount($count)
    {
        $faker = Faker\Factory::create();
        $i = 0;

        while ($i < $count)
        {
            Sneek\Account::create([
                'name' => $faker->word,
                'balance' => rand(0, 500),
            ]);

            $i ++;
        }
    }

}
