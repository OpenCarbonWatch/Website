/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import { createApp } from 'vue';
import AutocompleteActivity from './components/AutocompleteActivity.vue';
import AutocompleteGeography from './components/AutocompleteGeography.vue';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

createApp({
    components: {
        AutocompleteActivity,
        AutocompleteGeography,
    }
}).mount('#app');
