<template>
    <div id="app">
        <app-header></app-header>
        <router-view></router-view>
    </div>
</template>

<script>
    import AppHeader from "./components/AppHeader.vue";

    export default {
        components: {
            AppHeader
        },
        created () {
            this.$store.dispatch("checkUser");
        }
    }
</script>

<style lang="scss">
    #app {
        display: flex;
        flex-direction: column;

        min-height: 100vh;
    }

    .content-wrapper {
        flex: 1;

        display: flex;
        flex-direction: column;
    }
</style>
