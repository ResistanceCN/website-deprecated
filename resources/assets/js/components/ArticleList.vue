<template>
    <div class="container article-list-container">
        <div class="row">
            <div v-for="article in articles" class="article col-md-4 col-sm-6 col-xs-12">
                <md-card>
                    <md-card-media v-if="article.image">
                        <img :src="article.image" :alt="article.title">
                    </md-card-media>

                    <md-card-header>
                        <div class="md-title">{{ article.title }}</div>
                        <div class="md-subhead">{{ article.date }}</div>
                    </md-card-header>

                    <md-card-content v-if="!article.image">
                        <div>{{ article.description }}</div>
                    </md-card-content>
                </md-card>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['page'],
        data() {
            return {
                articles: []
            }
        },
        created() {
            this.getArticles();
        },
        methods: {
            getArticles() {
                // randomly generate some articles
                for (let id = this.page * 12 - 11; id <= this.page * 12; ++id) {
                    this.articles.push({
                        id,
                        title: "Hello World " + id,
                        date: this.date(new Date().setDate(id) / 1000),
                        description: "示例".repeat(Math.random() * 36)
                    });
                }
            },
            date(unixTimestamp) {
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

            .md-card-content {
                display: flex;

                div {
                    overflow: hidden;
                }
            }
        }
    }
</style>
