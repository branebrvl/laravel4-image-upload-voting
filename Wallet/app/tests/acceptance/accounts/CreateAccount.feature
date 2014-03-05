Feature: User creates an account
    As a user
    In order to track transactions
    I want to be able to create accounts

    Scenario: Navigating to create account
        Given I am on "accounts"
        And I follow "Create Account"
        Then the URL should match "accounts/create"

    Scenario: With valid credentials
        Given I am on "accounts/create"
        And I submit the new account form correctly
        Then I should see "All accounts"
        And I should see "Account created successfully"
        And I should see "HSBC"

    Scenario: With invalid credentials
        Given I am on "accounts/create"
        And I submit the new account form incorrectly
        Then I should see "There was a problem creating the account"
        And the URL should match "accounts/create"

