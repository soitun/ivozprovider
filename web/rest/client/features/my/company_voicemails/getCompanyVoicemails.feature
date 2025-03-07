Feature: Retrieve company voicemails
  In order to manage company voicemails
  As a user
  I need to be able to retrieve them through the API.

  @createSchema @userApiContext
  Scenario: Retrieve the company voicemails json list
    Given I add User Authorization header
     When I add "Accept" header equal to "application/json"
      And I send a "GET" request to "my/company_voicemails"
     Then the response status code should be 200
      And the response should be in JSON
      And the header "Content-Type" should be equal to "application/json; charset=utf-8"
      And the JSON should be equal to:
    """
      [
          {
              "name": "Alice",
              "lastname": "Allison",
              "id": 1,
              "terminal": 1,
              "extension": null,
              "outgoingDdi": null
          },
          {
              "name": "Bob",
              "lastname": "Bobson",
              "id": 2,
              "terminal": 2,
              "extension": null,
              "outgoingDdi": null
          }
      ]
    """
