<template>
    <div id="page-login" class="content-wrapper">
        <div class="ribbon"></div>
        <div class="container-fluid container-stretch register-form-container">
            <md-card>
                <md-card-header>
                    <div class="md-title">Last step</div>
                </md-card-header>

                <md-card-content>
                    <form novalidate @submit.stop.prevent="register">
                        <md-input-container>
                            <label>Email</label>
                            <md-input v-model="user.email" readonly></md-input>
                        </md-input-container>

                        <md-input-container>
                            <label>AgentName</label>
                            <md-input maxlength="15" v-model="name" required></md-input>
                        </md-input-container>

                        <div>
                            <md-radio v-model="faction" name="faction" md-value="1" class="md-primary">Resistance</md-radio>
                            <md-radio v-model="faction" name="faction" md-value="0" class="md-primary" md-theme="green">Enlightened</md-radio>
                        </div>

                        <md-button type="submit" class="md-raised md-primary" id="btn-register">Submit</md-button>
                    </form>
                </md-card-content>
            </md-card>
        </div>
    </div>
</template>

<script>
    import Axios from "axios";
    import { mapState } from 'vuex'
    import _ from "lodash";

    export default {
        data () {
            return {
                name: "",
                faction: "1",
            }
        },
        computed: mapState({
            googleUser: state => state.auth.googleUser,
            user: state => state.auth.user,
            token: state => state.auth.token
        }),
        watch: {
            user (newUser) {
                if (this.user.id)
                    this.$router.push("/");
            }
        },
        created () {
            if (this.user.id)
                this.$router.push("/");

            if (_.isEmpty(this.googleUser) || _.isEmpty(this.user) && !this.token)
                this.$router.push("/login");
        },
        methods: {
            register (user) {
                Axios.post('/api/register', {
                    token: this.googleUser.getAuthResponse().id_token,
                    name: this.name,
                    faction: this.faction
                }).then(response => {
                    if (response.data.user.id) {
                        this.$store.commit("LOGIN_SUCCESS", response.data);
                        this.$router.push("/");
                    } else {
                        // @TODO: Display error message
                    }
                }).catch(error => {
                    console.error(error.response.data.error);
                });
            }
        }
    }
</script>

<style lang="scss">
    .ribbon {
        height: 240px;
        background: #1E88E5;
        margin-bottom: -150px;
    }

    .register-form-container {
        display: flex;
        flex-direction: column;
        align-items: center;

        .md-card {
            width: 100%;
            max-width: 480px;
            margin-bottom: 60px;
        }

        #btn-register {
            margin: 2em 0 8px;
        }
    }
</style>
