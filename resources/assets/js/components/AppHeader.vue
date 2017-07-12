<template>
    <header>
        <md-whiteframe :md-elevation="$store.state.ui.headerType == 'default' ? 2 : 0">
            <md-toolbar class="header-toolbar">
                <div class="container container-flex header-container">
                    <router-link to="/" class="logo" v-show="headerType == 'default'">
                        <img src="/img/cantonres.svg" alt="CantonRES">
                    </router-link>

                    <md-button class="md-icon-button" v-show="headerType == 'article'" @click="$router.back()">
                        <md-icon>arrow_back</md-icon>
                    </md-button>

                    <div class="flex-placeholder"></div>

                    <router-link to="/login" tag="md-button" v-if="!user.id">LOG IN</router-link>
                    <router-link to="/profile" tag="md-button" class="name" v-else>{{ user.name }}</router-link>
                </div>
            </md-toolbar>
        </md-whiteframe>
    </header>
</template>

<script>
    import { mapState } from 'vuex'

    export default {
        computed: mapState({
            headerType: state => state.ui.headerType,
            user: state => state.auth.user
        })
    }
</script>

<style lang="scss">
    .header-toolbar.md-toolbar {
        background-color: #1976D2 !important;
    }

    .header-container {
        display: flex;
        flex-direction: row;
        align-items: center;

        align-self: stretch;

        .logo {
            padding: 0 16px;

            img {
                height: 32px;
            }
        }

        .name {
            text-transform: none;
        }
    }
</style>
