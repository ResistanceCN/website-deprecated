<template>
    <div class="container article-list-container">
        <div class="row">
            <div v-for="article in articles" class="article col-md-4 col-sm-6 col-xs-12">
                <md-card>
                    <md-card-area>
                        <md-card-media v-if="article.image">
                            <img :src="article.image" :alt="article.title">
                        </md-card-media>

                        <md-card-header>
                            <div class="md-title">{{ article.title }}</div>
                            <div class="md-subhead">{{ article.created_at }}</div>
                        </md-card-header>

                        <md-card-content v-if="!article.image">
                            <div>{{ article.description }}</div>
                        </md-card-content>
                    </md-card-area>

                    <md-card-actions>
                        <router-link :to="'/article/' + article.id" tag="md-button">READ MORE</router-link>
                    </md-card-actions>
                </md-card>
            </div>
        </div>
    </div>
</template>

<script>
    import Axios from "axios";

    export default {
        props: ["page"],
        data () {
            return {
                articles: []
            }
        },
        created () {
            this.getArticles();
        },
        methods: {
            getArticles () {
                Axios.get("/api/articles?page=" + this.page).then(response => {
                    this.articles = response.data;
                }).catch(error => {
                    //
                });
            },
            date (unixTimestamp) {
                let date = new Date(unixTimestamp * 1000);
                return date.getFullYear() + "-" + date.getMonth() + "-" + date.getDate();
            }
        }
    }
</script>

<style lang="scss">
    .article-list-container .row {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        align-items: stretch;
    }

    .article {
        margin-bottom: 24px;

        .md-card {
            height: 100%;
            max-height: 360px;

            .md-card-area {
                flex: 1;

                .md-card-content {
                    display: flex;

                    div {
                        overflow: hidden;
                    }
                }
            }
        }
    }
</style>
