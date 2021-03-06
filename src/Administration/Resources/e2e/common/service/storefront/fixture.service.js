const AdminApiService = require('./../administration/admin-api.service');
const StorefrontApiService = require('./storefront-api.service');
const _ = require('lodash');
const glob = require('glob');
const path = require('path');
const uuid = require('uuid/v4');

export default class StorefrontFixtureService {
    constructor() {
        this.apiClient = new StorefrontApiService(process.env.APP_URL);
        this.adminApiClient = new AdminApiService(process.env.APP_URL);
        this.basicFixture = '';

        // Automatic loading of fixtures
        glob.sync(path.join(__dirname, './fixture/*.js')).forEach((fileName) => {
            require(fileName);
        });
    }

    setBasicFixture(json) {
        this.basicFixture = this.loadJson(json);
    }

    createUuid() {
        return uuid();
    }

    mergeFixtureWithData(...args) {
        const result = _.merge({}, ...args);
        return result;
    }

    loadJson(fileName) {
        try {
            return require(`./../../@fixtures/${fileName}`);
        } catch (err) {
            global.logger.error(err);
        }
    }
}

global.StorefrontFixtureService = new StorefrontFixtureService();
