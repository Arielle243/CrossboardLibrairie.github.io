import {$} from "./functions/dom";

export class Product {
    id;

    constructor() {
        this.id = $('.product-data').dataset.id;
    }

    /**
     *
     * @returns {Promise<Array>}
     */
    async fetchComments() {
        const response = await fetch(`/ajax/products/${this.id}/comments`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            method: 'GET'
        });

        return await response.json();
    }
}