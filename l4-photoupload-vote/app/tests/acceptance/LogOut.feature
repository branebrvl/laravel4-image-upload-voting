Feature: Sign out
    In order to end the session
    I as a user have to logout 

    Scenario: Logout
        Given I am logged in
        # And I am on a desktop device
        When I go to "/admin/tags"
        Then I should see "All Tags"
        When I click on the element ".navbar-toggle"
        Then I should see the dropdown
        And I follow "logout"
        Then I should be on "/login"
        And I should see "Login"
