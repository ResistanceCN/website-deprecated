<template>
    <div id="page-login" class="content-wrapper">
        <div class="ribbon"></div>
        <div class="container-fluid container-stretch login-form-container">
            <md-card>
                <md-card-header>
                    <div class="md-title">Log in</div>
                </md-card-header>

                <md-card-content>
                    <p>Currently we only support signing in with Google account.</p>
                    <p>When clicking the button above, you agree that we could access and store your personal data, such as email, name and avatar from Google.</p>

                    <div class="btn-login">
                        <google-sign-in @success="success" @error="error"></google-sign-in>
                    </div>
                </md-card-content>
            </md-card>
        </div>
    </div>
</template>

<script>
    import Axios from "axios";
    import GoogleSignIn from "../components/GoogleSignIn.vue";

    export default {
        components: {
            GoogleSignIn
        },
        methods: {
            success (googleUser) {
                this.$store.commit("GOOGLE_SIGN_IN", googleUser);

                Axios.post('/api/login', {
                    token: googleUser.getAuthResponse().id_token
                }).then(response => {
                    this.$store.commit("LOGIN_SUCCESS", response.data);

                    if (response.data.id)
                        this.$router.push("/");
                    else
                        this.$router.push("/register");
                }).catch(error => {
                    console.error(error.response.data.error);
                });
            },
            error (error) {
                console.error(error);
            }
        }
    }
</script>

<style lang="scss">
    #page-login .ribbon {
        height: 240px;
        background: #1E88E5;
        margin-bottom: -150px;
    }

    .login-form-container {
        display: flex;
        flex-direction: column;
        align-items: center;

        .md-card {
            width: 100%;
            max-width: 480px;
            margin-bottom: 60px;
        }

        .btn-login {
            margin: 2em 0 8px;
        }
    }
</style>
