module.exports = {
    '@tags': ['product-inline-edit'],
    'open product listing': (browser) => {
        browser
            .assert.containsText('.sw-admin-menu__navigation-list-item.sw-product span.collapsible-text', 'Products')
            .click('a.sw-admin-menu__navigation-link[href="#/sw/product/index"]')
            .waitForElementVisible('.smart-bar__actions a')
            .waitForElementVisible('.sw-page__smart-bar-amount')
            .assert.containsText('.sw-page__smart-bar-amount', '(0)');
    },
    'create the product': (browser) => {
        browser
            .click('a[href="#/sw/product/create"]')
            .waitForElementVisible('.sw-product-detail-base')
            .assert.urlContains('#/sw/product/create')
            .assert.containsText('.sw-card__title', 'Information')
            .setValue('input[name=sw-field--product-name]', 'First one')
            .setValue('select[name=sw-field--product-manufacturerId]', 'shopware AG')
            .setValue('select[name=sw-field--product-catalogId]', 'Default catalogue')
            .setValue('select[name=sw-field--product-taxId]', '19%')
            .setValue('input[name=sw-field--price-gross]', '99')
            .click('.smart-bar__actions button.sw-button--primary')
            .waitForElementVisible('.sw-notifications .sw-alert')
            .assert.containsText('.sw-alert__message', 'successfully.')
            .assert.urlContains('#/sw/product/detail');
    },
    'go back to listing': (browser) => {
        browser
            .click('a.smart-bar__back-btn')
            .click('.sw-alert button.sw-alert__close')
            .waitForElementNotPresent('.sw-alert__message')
            .waitForElementVisible('.sw-grid-row:first-child .sw-context-button__button')
            .assert.containsText('.sw-product-list__column-product-name', 'First one');
    },
    'edit product name via inline editing and verify change': (browser) => {
        browser
            .moveToElement('.sw-grid-row:first-child', 0, 0).doubleClick()
            .clearValue('input[name=sw-field--item-name]')
            .setValue('input[name=sw-field--item-name]', 'Second one')
            .waitForElementVisible('.is--inline-editing .sw-button--primary')
            .click('.is--inline-editing .sw-button--primary')
            .waitForElementVisible('.sw-product-list__column-product-name')
            .assert.containsText('.sw-product-list__column-product-name', 'Second one');
    },
    'delete created product': (browser) => {
        browser
            .waitForElementVisible('.sw-grid-row:first-child .sw-context-button__button')
            .click('.sw-grid-row:first-child .sw-context-button__button')
            .waitForElementPresent('body > .sw-context-menu')
            .click('body > .sw-context-menu .sw-context-menu-item--danger')
            .waitForElementVisible('.sw-modal')
            .assert.containsText('.sw-modal .sw-product-list__confirm-delete-text', 'Do you really want to delete the product "Second one"?')
            .click('.sw-modal__footer button.sw-button--primary')
            .waitForElementNotPresent('.sw-product-list__column-product-name')
            .end();
    }
};