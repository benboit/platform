import { Component } from 'src/core/shopware';
import template from './sw-property-detail-base.html.twig';

Component.register('sw-property-detail-base', {
    template,

    props: {
        group: {
            type: Object,
            required: true,
            default() {
                return {};
            }
        }
    },

    data() {
        return {
            sortingTypes: [
                { value: 'numeric', label: this.$tc('sw-property.detail.numericSortingType') },
                { value: 'alphanumeric', label: this.$tc('sw-property.detail.alphanumericSortingType') },
                { value: 'position', label: this.$tc('sw-property.detail.positionSortingType') }
            ],
            displayTypes: [
                { value: 'media', label: this.$tc('sw-property.detail.mediaDisplayType') },
                { value: 'text', label: this.$tc('sw-property.detail.textDisplayType') },
                { value: 'color', label: this.$tc('sw-property.detail.colorDisplayType') }
            ]
        };
    }
});
