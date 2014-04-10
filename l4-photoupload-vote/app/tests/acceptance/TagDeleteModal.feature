Feature: Tag Delete Modal dialog
  
  Scenario: Open modal dialog
    Given I am logged in
    When I go to "/admin/tags"
      Then I should see "All Tags"
    When I click on the element ".add-tag"
    Then I should see the modal "Adding new Tag"
      # And I should see "Are you sure?"
