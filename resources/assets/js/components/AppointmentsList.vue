<template>
  <div class="container-fluid">
     <div v-for="appt in appointments" class="notification is-info">
      <div class="title is-4">
        {{ appt.client.first_name }} {{ appt.client.last_name }}
      </div>
      {{ formatTime(appt.start_time, appt.end_time) }}
      <br><br>
      <a class="button is-info is-outlined is-inverted">
        <i class="fa fa-graduation-cap" aria-hidden="true"></i> &nbsp
        Begin Session
      </a>
      <a class="button is-info is-outlined is-inverted">
        <i class="fa fa-calendar" aria-hidden="true"></i> &nbsp
        Appointment Details
      </a>
    </div>
  </div>

</template>

<script>
    export default {
        name: 'appointments-list',

        data() {
          return {
            appointments: [],
          }
        },

        computed: {
          //
        },

        methods: {
          formatTime(start, end) {
            return moment(start).format('ddd, h:mm A') + ' - ' + moment(end).format('h:mm A');
          }
        },

        created() {
          var root = this.$root;

          this.$http.get('/appointments/today')
              .then( response => {
                  console.log(response.data);
                  this.appointments = response.data;
              });
        },

        mounted() {

        },


    }
</script>
