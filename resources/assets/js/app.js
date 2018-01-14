import './bootstrap.js';

window.Vue = require('vue');

class Errors {
	constructor() {
		this.errors = {};
	}

	get(field) {
		if (this.errors[field]) {
			return this.errors[field][0];
		}
	}

	record(errors) {
		this.errors = errors.errors;
	}

	clear(field) {
		if (field) delete this.errors[field];

		this.errors = {};
	}
}

class Form {
	constructor(data) {
		this.originalData = data;

		for (let field in data) {
			this[field] = data[field];
		}

		this.errors = new Errors();
	}

	data() {
		let data = Object.assign({}, this);

		data.description = CKEDITOR.instances.description.getData();

		delete data.originalData;
		delete data.errors;

		return data;
	}

	reset() {
		for (let field in originalData) {
			this[field] = '';
		}
	}

	submit(requestType, url) {
    	axios[requestType](url, this.data())
			.then( this.onSuccess.bind(this) )
			.catch( this.onFail.bind(this) )
	}

	onSuccess(response) {
		alert(response.data.message);
		window.location.reload(true);
		this.errors.clear();
	}

	onFail(error) {
		this.errors.record(error.response.data);
	}
}

import ClientsTable from './components/ClientsTable.vue'
import AppNavbar from './components/AppNavbar.vue'
import AppointmentsList from './components/AppointmentsList.vue'
import AutoSearch from './components/AutoSearch.vue'
import FullCalendar from './components/FullCalendar.vue'
import SessionNotes from './components/SessionNotes.vue'

//import {dataStore} from './components/dataStore.vue'

const app = new Vue({
    el: '#app',

    components: {
    	ClientsTable,
    	AppNavbar,
    	AppointmentsList,
    	AutoSearch,
    	FullCalendar,
    	SessionNotes,
    },

    data: {
    	form: new Form({
    		title: '',
    		description: '',
    	}),

    	clients: [],

    	csrfToken: App.csrfToken,
    	stripeKey: App.stripeKey,
    },

});
