Feature: Serach Renders
  In order to search renders
  As a app user
  I need to see renders when I use search box

  Scenario: Search Render Posts
    Given I am on "/recent"
    When I fill in "q" with "sit"
        And I press enter
    Then I should see "Sit"
    And I should see "Search results for"
