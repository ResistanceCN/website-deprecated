<template>
    <div id="g-signin-button"></div>
</template>

<script>
    export default {
        mounted () {
            if (!window.gapi) {
                console.error("Google platform library not loaded");
                return
            }

            if (!window.Laravel.googleClientID) {
                console.error("Client ID not specified");
                return
            }

            window.gapi.load('auth2', () => {
                window.gapi.auth2.init({
                    client_id: window.Laravel.googleClientID
                });

                window.gapi.signin2.render('g-signin-button', {
                    scope: 'profile email',
                    height: 36,
                    longtitle: true,
                    theme: 'dark',
                    onsuccess: user => this.$emit('success', user),
                    onfailure: error => this.$emit('error', error)
                });
            })
        }
    }
</script>

<style lang="scss">
    #g-signin-button .abcRioButton {
        &:hover {
            box-shadow: 0 2px 4px 0 rgba(0,0,0,.25);
        }

        &:focus, &:active {
            box-shadow: 0 3px 5px -1px rgba(0, 0, 0, 0.2),
                        0 5px 8px rgba(0, 0, 0, 0.14),
                        0 1px 14px rgba(0, 0, 0, 0.12);
        }
    }
</style>
