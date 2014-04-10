Feature: Sign in to the website
    In order to upload or like images

    Scenario: Login
        Given I am on "/login"
            And I should see "Login"
        When I fill in "username" with "branislav.vladisavljev@evolvemediallc.com"
            And I fill in "password" with "changeme"
            And I press "Login"
        Then I should be on "/user"
            And I should see "My Renders"
