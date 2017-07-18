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
    import checklist from "../includes/showdown/checklist";
    import xss from "../includes/showdown/xss";

    let converter = new showdown.Converter({
        parseImgDimensions: true,
        headerLevelStart: 2,
        simplifiedAutoLink: true,
        excludeTrailingPunctuationFromURLs: true,
        strikethrough: true,
        tables: true,
        tasklists: true,
        encodeEmails: true,
        openLinksInNewWindow: true,
        extensions: [checklist, xss]
    });

    export default {
        data () {
            return {
                article: {}
            }
        },
        computed: {
            content () {
                if (_.isEmpty(this.article))
                    return "";

                return converter.makeHtml(this.article.content.content);
            }
        },
        created () {
            this.$store.commit("SET_HEADER_TYPE", "article");
            this.getArticle();
        },
        updated () {
            MathJax.Hub.Typeset();
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
    .article-container {
        .md-card {
            margin-bottom: 60px;

            .md-card-content {
                h2 {
                    font-size: 1.6em;
                }

                h3 {
                    font-size: 1.4em;
                }

                h4 {
                    font-size: 1.15em;
                }

                pre {
                    display: block;
                    border: 0;
                    border-radius: 0;
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
                            list-style-type: none;

                            .material-icons {
                                line-height: 22px;
                                font-size: 18px;
                                vertical-align: bottom;
                                margin-right: 0.5em;
                            }
                        }
                    }

                    ol, ul {
                        margin: 0.5em -16px -0.5em;

                        li {
                            padding-left: 36px;

                            &:last-child {
                                border-bottom: none;
                            }
                        }
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
                        top: 16px;
                    }

                    p:first-of-type {
                        margin-top: 0;
                    }

                    p:last-of-type {
                        margin-bottom: 0;
                    }

                    blockquote {
                        font-size: 1em;
                        padding: 8px 0 8px 16px;
                        margin: 16px 0;
                        border-left: 4px solid #ddd;

                        &:before {
                            display: none;
                        }

                        &:last-child {
                            margin-bottom: 0;
                        }
                    }
                }

                pre {
                    margin: 1.6em -16px;
                    padding: 1em 16px;
                    border-top: 1px solid #eeeeee;
                    border-bottom: 1px solid #eeeeee;
                    background: #fafafa;
                    overflow-x: auto;
                }

                code {
                    background-color: transparent;
                    color: #3d6983;
                }

                iframe {
                    border: none;
                }

                table {
                    border-top: 1px solid #eeeeee;
                    border-left: 1px solid #eeeeee;
                    border-collapse: collapse;

                    th, td {
                        border-right: 1px solid #eeeeee;
                        border-bottom: 1px solid #eeeeee;
                        padding: 5px 10px;
                    }

                    tbody tr:nth-child(2n + 1) {
                        th, td {
                            background: #fafafa;
                        }
                    }
                }

                .MathJax_SVG {
                    outline: none;
                }
            }
        }
    }
</style>
