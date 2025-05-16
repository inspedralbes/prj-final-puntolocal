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
        cy.contains('Panell de Control del Comerç').click();

        cy.viewport(Cypress.config('viewportWidth'), Cypress.config('viewportHeight'));
        if (Cypress.config('viewportWidth') < 1040) {
            // VEURE PRODUCTES
            cy.get('#toggleSidebarMobile').click();
            cy.contains('Productes').click();
            cy.contains('Llistat').click();
            cy.get('#toggleSidebarMobile').click();

            // VEURE COMANDES
            cy.get('#toggleSidebarMobile').click();
            cy.contains('Ventas').click();
            cy.contains('Comandes').click();
            cy.contains('Historial').click();
            cy.get('#toggleSidebarMobile').click();

            // DADES DEL COMERÇ
            cy.get('#toggleSidebarMobile').click();
            cy.contains('Configuración').click();
            cy.contains('Dades del comerç').click();
            cy.get('#toggleSidebarMobile').click();
        } else {
            // VEURE PRODUCTES
            cy.contains('Productes').click();
            cy.contains('Llistat').click();

            // VEURE COMANDES
            cy.contains('Ventas').click();
            cy.contains('Comandes').click();
            cy.contains('Historial').click();

            // DADES DEL COMERÇ
            cy.contains('Configuración').click();
            cy.contains('Dades del comerç').click();
        }
    });
});