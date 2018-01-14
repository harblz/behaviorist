<script>
    export default {
        name: 'clients-table',

        data() {
          return {
            clients: [],
            data: [],
            name: '',
            selected: null,
            selectedID: -1,
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

        methods: {
          toDollars: function(charge) {
            return '$' + charge/100;
          },

          formatDate: function(date) {
            return moment(date).format("h:mm a dddd, MMM D, YYYY");
          },

          formatDateToAge: function(date) {
            var years = moment().diff(date, 'years');
            var months = moment().diff(date, 'months');
            //return moment(date).fromNow().split(" ")[0];
            return years + ' years and '+months % 12+' months' ;
          },

          getAgeInYears: function(date) {
            return moment().diff(date, 'years');
          },

          birthdayCheck: function(date) {
            if ( moment(date).date() == moment().date() && moment(date).month() == moment().month() ) {
              return true;
            } else {
              return false;
            }
          }
        },

        watch: {
          selected(selected) {
            this.selectedID = selected.id;
          }
        },

        created() {
          var root = this.$root;

          this.$http.get('/clients/all')
              .then( response => {
                  this.clients = response.data;
                  this.data = response.data;
                  root.clients = response.data;
              });
        },

        mounted() {

        },


    }
</script>

<template>
  <section>
    <p v-if="selected" class="content"><b>Selected:</b> {{ selected.first_name + ' ' + selected.last_name }}</p>

    <b-field label="Seach:" style="padding-bottom: 10px;">
        <b-autocomplete
            v-model="name"
            placeholder="Search by first name"
            :data="filteredDataObj"
            field="first_name"
            @select="option => selected = option">
        </b-autocomplete>
    </b-field>

    <b-table
        :data="clients"
        :selected.sync="selected"
        detailed
        default-sort="first_name"
        :narrowed="true"
        :striped="true"
        :row-class="(row, index) => row.id === selectedID ? 'is-warning' : ''">
        >

        <template slot-scope="props">
            <b-table-column field="first_name" label="First Name" width="150" sortable>
                <small v-if="birthdayCheck(props.row.dob)">🎂</small>
                {{ props.row.first_name }}
                <small class="has-text-primary has-text-weight-bold" v-if="birthdayCheck(props.row.dob)">
                  Celebrating {{ getAgeInYears(props.row.dob) }} years!
                </small>
            </b-table-column>

            <b-table-column field="last_name" label="Last Name" width="120" sortable>
                {{ props.row.last_name }}
            </b-table-column>

            <b-table-column field="toolbar" label="Toolbar" width="385" sortable>
              <a class="button is-primary is-outlined">
                <i class="fa fa-line-chart" aria-hidden="true"></i> &nbsp
                Chart
              </a>
              <a class="button is-primary is-outlined">
                <i class="fa fa-graduation-cap" aria-hidden="true"></i> &nbsp
                Begin Session
              </a>
              <a class="button is-primary is-outlined">
                <i class="fa fa-area-chart" aria-hidden="true"></i> &nbsp
                Planning
              </a>
            </b-table-column>

            <b-table-column field="dob" label="DOB" sortable centered>
                  {{ formatDateToAge(props.row.dob) }}
            </b-table-column>

            <b-table-column field="created_at" label="Last Session" sortable>
                  {{ formatDate(props.row.created_at) }}
            </b-table-column>
        </template>

        <template slot="detail" slot-scope="props">
          <article class="media">
              <figure class="media-left">
                  <p class="image is-64x64">
                      <img src="/img/placeholder-128x128.png">
                  </p>
              </figure>
              <div class="media-content">
                  <div class="content">
                      <p>
                          <strong>{{ props.row.first_name }} {{ props.row.last_name }}</strong>
                          <small>Age </small>
                          <small> {{ formatDateToAge(props.row.dob) }} </small>
                          <small v-if="birthdayCheck(props.row.dob)"> 🎂 </small>
                          <p class="has-text-info has-text-weight-bold" v-if="birthdayCheck(props.row.dob)">
                            Hey! It's {{props.row.first_name}}'s birthday today!
                          </p>
                          Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                          Proin ornare magna eros, eu pellentesque tortor vestibulum ut.
                          Maecenas non massa sem. Etiam finibus odio quis feugiat facilisis.
                      </p>
                  </div>
              </div>
          </article>
      </template>
    </b-table>
  </section>
</template>

<style>
    tr.is-warning {
        background: hsl(30, 100%, 67%) !important;
        color: black !important;
    }
    .b-table .table:focus {
      outline: none !important;
    }
</style>
