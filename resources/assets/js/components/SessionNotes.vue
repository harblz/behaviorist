<template>
    <section class="session-notes">
        <button class="button block" @click="activeTab = 0">New Note</button>
        <b-tabs v-model="activeTab">
            <b-tab-item label="New Note">
                <session-note-form :form="form"></session-note-form>
            </b-tab-item>

            <b-tab-item v-for="(session, index) in sessionNotes" :key="session.id" :label="(index+1) + '. ' + session.user.first_name + ' ' + session.user.last_name">
                <div v-html="session.note"></div>
            </b-tab-item>

        </b-tabs>
    </section>
</template>

<script>

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
            //window.location.reload(true);
            this.errors.clear();
        }

        onFail(error) {
            this.errors.record(error.response.data);
        }
    }

    import SessionNoteForm from './SessionNoteForm.vue'

    export default {
        name: 'session-notes',

        components: {
            SessionNoteForm,
        },

        props: [
            'clientID',
            'staffID',
        ],

        data() {
            return {
                activeTab: 0,
                sessionNotes: {},
                form: new Form({
                    client_id: '',
                    description: '',
                }),
            }
        },

        methods: {
            onSubmit() {
                this.form.submit('post', '/posts');
            },
        },

        watch: {
            clientID(id) {
                if ( id !== null ) {
                    this.form.client_id = id;
                    this.$http.get('/session/notes/'+id)
                        .then( response => {
                            this.sessionNotes = response.data;
                            console.log(this.sessionNotes);
                        });
                }
            }
        },

        mounted() {
            //CKEDITOR.replace('description');
        },

    }
</script>
