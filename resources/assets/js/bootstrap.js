import Chart from 'Chart.js'

import Vue from 'vue'
import Buefy from 'buefy'

Vue.use(Buefy, {
	defaultIconPack: 'fa',
})

import moment from 'moment';
window.moment = moment;

window.Vue = require('vue');
require('vue-resource');

Vue.http.interceptors.push(function (request, next) {
	request.headers['X-CSRF-TOKEN'] = App.csrfToken;
	next();
});

window._ = require('lodash');

try {
    window.$ = window.jQuery = require('jquery');
} catch (e) {}


import axios from 'axios';

window.axios = axios;

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};
/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
