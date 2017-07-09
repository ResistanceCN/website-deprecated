<template>
    <header>
        <md-whiteframe md-elevation="2">
            <md-toolbar class="header-toolbar">
                <div class="container container-flex header-container">
                    <router-link to="/" class="logo">
                        <img src="/img/cantonres.svg" alt="CantonRES">
                    </router-link>

                    <div class="flex-placeholder"></div>

                    <template v-if="!$store.state.auth.user.id">
                        <nav class="hidden-xs">
                            <router-link to="/login" tag="md-button">LOG IN</router-link>
                        </nav>

                        <md-menu md-direction="bottom left" md-size="2" class="hidden visible-xs">
                            <md-button class="md-icon-button" md-menu-trigger>
                                <md-icon>more_vert</md-icon>
                            </md-button>

                            <md-menu-content style="margin-top: -20px;">
                                <router-link to="/login" tag="md-menu-item">LOG IN</router-link>
                            </md-menu-content>
                        </md-menu>
                    </template>
                    <span v-else>{{ $store.state.auth.user.name }}</span>
                </div>
            </md-toolbar>
        </md-whiteframe>
    </header>
</template>

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
                height: 48px;
            }
        }
    }
</style>
