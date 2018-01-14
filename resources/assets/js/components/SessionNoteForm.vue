<template>
    <div>
        <form method="POST" action="/session/notes/store" @submit.prevent="onSubmit">
            <!-- @keydown="form.errors.clear($event.target.title)" -->

            <div class="control">
                <label for="description" class="label" style="font-size: 1.25rem;text-align: left;">Creating a New Session Note</label>

                <input type="textarea" id="description" name="description" class="input" v-model="form.description">

                <span class="help is-danger" v-text="form.errors.get('description')" style="margin-bottom: 10px;"></span>
            </div>

            <div class="control">
                <button class="button is-primary">Save Session Note</button>
            </div>
        </form>

        <br>
    </div>
</template>


<script>
    //import {dataStore} from './dataStore.vue'

    export default {

        props: ['form'],

        data() {
          return {

          }
        },

        methods: {
            onSubmit() {
                this.form.submit('post', '/session/notes/store');
            },
        },

        created() {

        },

        mounted() {
            CKEDITOR.replace('description');
        }
    }
</script>
