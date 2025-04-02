// NPX CYPRESS OPEN
import { vModelDynamic } from "vue";

describe('Test de login', () => {
    beforeEach(() => {
        cy.visit('http://localhost:3000/login', {
            onBeforeLoad(win) {
                cy.stub(win.navigator.permissions, 'query').callsFake((permission) => {
                    if (permission.name === 'geolocation') {
                        return Promise.resolve({ state: 'granted' });
                    }
                    return Promise.resolve({ state: 'denied' });
                });

                cy.stub(win.navigator.geolocation, 'getCurrentPosition')
                    .callsFake((cb) => {
                        return cb({
                            coords: {
                                latitude: 41.386326,
                                longitude: 2.105910
                            }
                        });
                    });
            }
        });

        cy.get('input[id=email]').type(`a23agunovnov@inspedralbes.cat`);
        cy.get('input[id=password]').type(`perseverar`);
        cy.contains('Iniciar sessió').click();
        cy.url().should('eq', 'http://localhost:3000/');
    });

    it('S\'ha d\'iniciar sessió correctament', () => {
        cy.contains('Perfil').click();
        cy.contains('Panel de Control del Comercio').click();

        cy.viewport(Cypress.config('viewportWidth'), Cypress.config('viewportHeight'));
        if (Cypress.config('viewportWidth') < 1040) {
            // VEURE PRODUCTES
            cy.get('#toggleSidebarMobile').click();
            cy.contains('Productes').click();
            cy.contains('Llistat').click();
            cy.get('#toggleSidebarMobile').click();
        } else {
            // VEURE PRODUCTES
            cy.contains('Productes').click();
            cy.contains('Llistat').click();
        }

        cy.contains('Editar').first().click();
        cy.get('input[id=name]').type(`Producte modificat`);

    });
});