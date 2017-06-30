<template>
    <div class="container pagination-container" v-show="total > 1">
        <router-link v-show="page > 1" :to="'/articles/page/' + prev" tag="md-button" class="md-icon-button">
            <md-icon>arrow_back</md-icon>
        </router-link>
        <div class="flex-placeholder"></div>
        <router-link v-show="page < total" :to="'/articles/page/' + next" tag="md-button" class="md-icon-button">
            <md-icon>arrow_forward</md-icon>
        </router-link>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                total: 3
            }
        },
        computed: {
            page() {
                return parseInt(this.$route.params.page) || 2;
            },
            prev() {
                return this.page - 1 || 1;
            },
            next() {
                return this.page + 1;
            }
        },
        created() {
            // get total pages
        }
    }
</script>

<style lang="scss">
    .pagination-container {
        display: flex;
        flex-direction: row;
    }
</style>
