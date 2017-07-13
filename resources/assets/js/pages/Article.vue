<template>
    <div id="page-article" class="content-wrapper">
        <div class="ribbon"></div>

        <div class="container container-stretch article-container">
            <md-card>
                <md-card-header>
                    <div class="md-title">{{ article.title }}</div>
                    <div class="md-subhead">{{ article.published_at }}</div>
                </md-card-header>

                <md-card-content>
                    <div v-html="content"></div>
                </md-card-content>
            </md-card>
        </div>
    </div>
</template>

<script>
    import showdown from "showdown";

    export default {
        data () {
            return {
                article: {}
            }
        },
        computed: {
            content () {
                let converter = new showdown.Converter({
                    parseImgDimensions: true,
                    headerLevelStart: 2,
                    simplifiedAutoLink: true,
                    excludeTrailingPunctuationFromURLs: true,
                    strikethrough: true,
                    tables: true,
                    tasklists: true,
                    encodeEmails: true,
                    openLinksInNewWindow: true
                });

                return converter.makeHtml(this.article.content);
            }
        },
        created () {
            this.$store.commit("SET_HEADER_TYPE", "article");
            this.getArticle();
        },
        beforeRouteUpdate (to, from, next) {
            this.getArticle();
            next();
        },
        beforeRouteLeave (to, from, next) {
            this.$store.commit("SET_HEADER_TYPE", "default");
            next();
        },
        methods: {
            getArticle () {
                Axios.get("/api/articles/" + this.$route.params.id + "?content=1").then(response => {
                    this.article = response.data;
                }).catch(error => {
                    this.$router.back();
                });
            }
        }
    }
</script>

<style lang="scss">
    #page-article .ribbon {
        height: 240px;
        background: #1976D2;
        margin-bottom: -150px;
    }

    .article-container {
        .md-card {
            margin-bottom: 60px;

            .md-card-content {
                h2, h3, h4, h5, h6 {
                    font-weight: normal;
                    display: block;
                    margin: 0.5em 0;
                }

                h2, h3 {
                    padding: 0 16px 0.5em;
                    margin: 0.8em -16px;
                    border-bottom: 1px solid #eee;
                }

                pre {
                    display: block;
                    border: 0px;
                    border-radius: 0px;
                }

                ol, ul {
                    list-style-position: inside;
                    padding: 0;
                    margin: 1.6em -16px;
                    border-top: 1px dashed #eeeeee;
                    background: #fafafa;

                    li {
                        margin: 0;
                        padding: 0.5em 16px;
                        border-bottom: 1px dashed #eeeeee;

                        &.task-list-item {
                            padding-left: 2.8em;
                        }
                    }
                }

                ul {
                    list-style-type: square;

                    ul {
                        list-style-type: circle;
                    }
                }

                blockquote {
                    margin: 0;
                    padding: 1em 0 1em 48px;
                    font-size: 1.2em;
                    color: #888888;
                    position: relative;

                    &:before {
                        content: "format_quote";
                        font-family: "Material Icons";
                        font-size: 40px;
                        transform: rotate(180deg);
                        color: #dddddd;
                        position: absolute;
                        left: 0;
                        top: 12px;
                    }

                    p:first-of-type {
                        margin-top: 0;
                    }

                    p:last-of-type {
                        margin-bottom: 0;
                    }
                }

                pre {
                    margin: 1.6em -16px;
                    padding: 1em 16px;
                    border-top: 1px solid #eeeeee;
                    border-bottom: 1px solid #eeeeee;
                    background: #fafafa;
                    word-wrap: break-word;
                    word-break: break-all;
                }

                code {
                    background-color: transparent;
                    color: #3d6983;
                }

                iframe {
                    border: none;
                }
            }
        }
    }
</style>
