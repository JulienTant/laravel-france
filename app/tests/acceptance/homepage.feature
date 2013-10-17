Feature: Homepage
    Scenario: See login page
    Given I am on "/"
    And I fill in "name" with "admin"
    And I fill in "password" with "wrong password"
    And I press "Envoyer"
    Then I should see "Identifiants incorrects"
