Feature: Serach Renders
  In order to search renders
  As a app user
  I need to see renders when I use search box

  Scenario: Search Render Posts
    Given I am on "/recent"
    When I fill in "q" with "es"
        And I press enter
    Then I should see "Omnis qui"
    And I should see "Search results for"
