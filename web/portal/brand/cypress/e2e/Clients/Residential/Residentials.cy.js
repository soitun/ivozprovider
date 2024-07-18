import CompaniesCollection from '../../../fixtures/Provider/Companies/getCollection.json';
import { deleteCompany, postCompany, putCompany } from './Residentials.tests';

describe('in Residential Companies', () => {
  beforeEach(() => {
    cy.prepareGenericPactInterceptors('VirtualPbxs');
    cy.before();

    cy.get('svg[data-testid="MapsHomeWorkIcon"]').first().click();
    cy.contains('Residentials').click();

    cy.get('header').should('contain', 'Residentials');

    cy.get('table').should(
      'contain',
      CompaniesCollection.body.find((element) => element.type === 'residential')
        .id
    );
  });

  ///////////////////////
  // POST
  ///////////////////////
  it('add Residential Companies', postCompany);

  ///////////////////////////////
  // PUT
  ///////////////////////////////
  it('edit Residential Companies', putCompany);

  ///////////////////////
  // DELETE
  ///////////////////////
  it('delete Residential Companies', deleteCompany);
});
