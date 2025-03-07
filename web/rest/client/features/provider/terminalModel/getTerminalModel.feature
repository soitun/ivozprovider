Feature: Retrieve terminal models
  In order to manage terminal models
  As a client admin
  I need to be able to retrieve them through the API.

  @createSchema
  Scenario: Retrieve the terminal models json list
    Given I add Company Authorization header
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "terminal_models"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the JSON should be equal to:
    """
      [
          {
              "iden": "Generic",
              "name": "Generic SIP Model",
              "id": 1
          },
          {
              "iden": "YealinkT21P_E2",
              "name": "YealinkT21P_E2",
              "id": 2
          }
      ]
    """

  Scenario: Retrieve certain terminal models json
    Given I add Company Authorization header
    When I add "Accept" header equal to "application/json"
    And I send a "GET" request to "terminal_models/1"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json; charset=utf-8"
    And the JSON should be equal to:
    """
      {
          "iden": "Generic",
          "name": "Generic SIP Model",
          "description": "Generic SIP Model",
          "id": 1
      }
    """
