
<script>

    export default {
        data() {
            return {
                data: [],
                name: '',
                selected: null
            }
        },

        computed: {
            filteredDataObj() {
                return this.data.filter((option) => {
                    return option.first_name
                        .toString()
                        .toLowerCase()
                        .indexOf(this.name.toLowerCase()) >= 0
                })
            }
        },

        created() {
            var root = this.$root;

            this.$http.get('/clients/all')
              .then( response => {
                  this.data = response.data;
            });
        },
    }
</script>

<template>
    <section>
        <p v-if="selected" class="content"><b>Selected:</b> {{ selected.first_name + ' ' + selected.last_name }}</p>
        <b-field label="Seach:">
            <b-autocomplete
                v-model="name"
                placeholder="Search by first name"
                :data="filteredDataObj"
                field="first_name"
                @select="option => selected = option">
            </b-autocomplete>
        </b-field>
        <br>
    </section>
</template>

