<template>
    <div id="page-home" class="content-wrapper">
        <section class="banner">
            <div class="container">
                <h1>Welcome to CantonRES</h1>
                <p class="description">It time to move. Join Resistance!</p>
                <router-link to="/form/join" tag="md-button" id="btn-join" class="md-raised md-primary">JOIN US</router-link>
                <router-link to="/tutorial" tag="md-button" id="btn-tutorial" class="md-raised md-primary">TUTORIAL</router-link>
            </div>

            <div class="compose container">
                <md-theme mdName="default-accent">
                    <router-link to="/compose" tag="md-button" class="md-fab">
                        <md-icon>edit</md-icon>
                    </router-link>
                </md-theme>
            </div>
        </section>

        <section class="articles">
            <article-list :page="1"></article-list>
        </section>

        <section class="pagination">
            <pagination></pagination>
        </section>
    </div>
</template>

<script>
    import ArticleList from "../components/ArticleList.vue";
    import Pagination from "../components/Pagination.vue";

    export default {
        components: {
            ArticleList,
            Pagination
        }
    }
</script>

<style lang="scss">
    .banner {
        position: relative;
        padding-top: 80px;
        padding-bottom: 80px;
        background: #1E88E5;
        color: #fff;
        text-align: center;

        h1 {
            line-height: 1.2;
            margin-top: 0;
        }

        p {
            font-size: 1.2em;
            margin: 0 0 1em;
        }

        #btn-join {
            background-color: #64DD17;
        }

        #btn-tutorial {
            background-color: #00B0FF;
        }

        .compose {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            margin: 0 auto -34px;

            .md-button {
                float: right;
            }
        }
    }

    #page-home {
        .articles {
            padding-top: 60px;
        }

        .pagination {
            padding-bottom: 40px;
        }
    }
</style>
