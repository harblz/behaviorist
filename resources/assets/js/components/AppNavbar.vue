<template>
    <nav class="navbar">
        <div class="navbar-brand">
            <a href="/home" class="navbar-item">
                Behaviorist Tech
            </a>
            <a href="/dashboard" class="navbar-item"><b-icon pack="fa" icon="tachometer"></b-icon>&nbsp Dashboard</a>
            <a href="/schedule" class="navbar-item"><b-icon pack="fa" icon="calendar"></b-icon>&nbsp Schedule</a>
            <a href="/clients" class="navbar-item"><b-icon pack="fa" icon="group"></b-icon>&nbsp Clients</a>
            <a class="navbar-item"><b-icon pack="fa" icon="book"></b-icon>&nbsp Planning & Reports</a>
            <a class="navbar-item">|</a>
            <a href="https://github.com/harblz/alphaData" class="navbar-item"><b-icon pack="fa" icon="github"></b-icon></a>
            <a class="navbar-item"><b-icon pack="fa" icon="bug"></b-icon></a>
            <a class="navbar-item"><b-icon pack="fa" icon="twitter"></b-icon></a>
        </div>

        <div class="navbar-menu">
            <div class="navbar-end">
                <b-dropdown v-if="loginStatus" position="is-bottom-left">
                    <a class="navbar-item" slot="trigger">
                        <span> Welcome, <b>{{ user.first_name }}</b> </span>
                        <b-icon icon="arrow_drop_down"></b-icon>
                    </a>

                    <b-dropdown-item custom paddingless>
                        <form action="/logout" method="POST">
                            <input type="hidden" name="_token" id="csrf-token" v-model="csrfToken" />
                            <div class="modal-card" style="width:300px;">
                                <section class="modal-card-body">
                                    <button class="button is-primary" style="float: left;">Your Profile</button>
                                    <button class="button is-primary" style="float: right;">Logout</button>
                                </section>
                            </div>
                        </form>
                    </b-dropdown-item>
                </b-dropdown>

                <b-dropdown v-else="loginStatus" position="is-bottom-left">
                    <a class="navbar-item" slot="trigger">
                        <span>Login</span>
                        <b-icon icon="arrow_drop_down"></b-icon>
                    </a>

                    <b-dropdown-item custom paddingless>
                        <form method="POST" action="/login">
                            <input type="hidden" name="_token" id="csrf-token" v-model="csrfToken" />
                            <div class="modal-card" style="width:300px;">
                                <section class="modal-card-body">
                                    <b-field label="Email">
                                        <b-input
                                            type="email"
                                            name="email"
                                            placeholder="Your email"
                                            required>
                                        </b-input>
                                    </b-field>

                                    <b-field label="Password">
                                        <b-input
                                            type="password"
                                            name="password"
                                            password-reveal
                                            placeholder="Your password"
                                            required>
                                        </b-input>
                                    </b-field>

                                    <b-checkbox>Remember me</b-checkbox>
                                </section>
                                <footer class="modal-card-foot">
                                    <button type="submit" class="button is-primary">
                                        Login
                                    </button>
                                </footer>
                            </div>
                        </form>
                    </b-dropdown-item>
                </b-dropdown>
            </div>
        </div>
    </nav>
</template>

<script>
    //import logo from '@/assets/buefy.png'

    export default {
        data() {
            return {
                csrfToken: this.$root.csrfToken,
                loginStatus: false,
                user: [],
            }
        },

        mounted() {
            var auth = document.querySelector("meta[name='login-status']").content;

            this.$http.get('/user/login-status')
              .then( response => {
                    this.loginStatus = response.data.status;
                    this.user = response.data.user;
              });
            }
    }
</script>
