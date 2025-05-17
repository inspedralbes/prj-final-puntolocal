// NPX CYPRESS OPEN
import { vModelDynamic } from "vue";

describe('Test de admin', () => {
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
    });

    // AFEGIR PRODUCTE
    it('S\'ha d\'iniciar sessió correctament', () => {
        cy.contains('Perfil').click();
        cy.contains('Panell de Control del Comerç').click();

        cy.viewport(Cypress.config('viewportWidth'), Cypress.config('viewportHeight'));
        if (Cypress.config('viewportWidth') < 1040) {
            cy.get('#toggleSidebarMobile').click();
            cy.contains('Productes').click();
            cy.contains('Llistat').click();
            cy.get('#toggleSidebarMobile').click();
        } else {
            cy.contains('Productes').click();
            cy.contains('Llistat').click();
        }

        cy.contains('Afegir nou producte').click();

        cy.get('input[id=nom-producte]').type('Pantalo de proba');
        cy.get('select[id=category]').select('Ropa Formal')
        cy.get('input[id=precio]').type('99.99');
        cy.get('input[id=stock]').type('10');
        cy.get('textarea').type('Descripció del producte');
        cy.get('input[type="file"]').selectFile('cypress/fixtures/nature.webp', { force: true });
        cy.contains('Guardar').click();

        // EDITAR EL PRODUCTE
        cy.contains('Editar').first().click();
        cy.get('input[id=name]').type(`Producte modificat`);
        cy.contains('Guardar').click();

        // ELIMINAR EL PRODUCTE
        cy.contains('Eliminar item').first().click();
        cy.contains('Si, estoy seguro').click();

        // MODIFICAR DADES DEL COMERÇ
        if (Cypress.config('viewportWidth') < 1040) {
            cy.get('#toggleSidebarMobile').click();
            cy.contains('Configuración').click();
            cy.contains('Dades del comerç').click();
            cy.get('#toggleSidebarMobile').click();
        } else {
            cy.contains('Configuración').click();
            cy.contains('Dades del comerç').click();
        }

        cy.wait(1500);
        cy.get('#telefono').clear();
        cy.get('#telefono').type('612976292');
    });
});