Feature: User edits an account
    As a user
    I want to update my account details
    So that it will be more personalised to me

    Scenario: With valid credentials
        Given there is 1 account
        And I am on "accounts/1/edit"
        And I submit the edit account form correctly
        Then the URL should match "accounts"
        And I should see "Account updated successfully"
        And I should see "My Personal Account"


    Scenario: With invalid credentials
        Given there is 1 account
        And I am on "accounts/1/edit"
        And I submit the edit account form incorrectly
        Then the URL should match "accounts/1/edit"
        And I should see "There was a problem updating the account"

