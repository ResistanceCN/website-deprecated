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
    import dom from "../includes/showdown/dom";
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
        extensions: [dom, xss]
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

            @media (min-width: 768px) {
                .md-card-header {
                    padding: 24px 32px 16px;
                }
            }

            @media (min-width: 992px) {
                .md-card-header {
                    padding: 32px 48px 16px;
                }
            }

            .md-card-content {
                @media (min-width: 768px) {
                    padding-left: 32px;
                    padding-right: 32px;
                }

                @media (min-width: 992px) {
                    padding-left: 48px;
                    padding-right: 48px;
                }

                h2 {
                    font-size: 1.6em;
                }

                h3 {
                    font-size: 1.4em;
                }

                h4 {
                    font-size: 1.15em;
                }

                a {
                    color: #1E88E5;
                }

                pre {
                    display: block;
                    border: 0;
                    border-radius: 0;
                }

                ol, ul {
                    margin: 1.6em 0;
                    padding-left: 24px;

                    li {
                        margin-top: 8px;
                    }

                    .task-list-item {
                         list-style-type: none;
                         margin-left: -20px;

                         .material-icons {
                             line-height: 22px;
                             font-size: 18px;
                             vertical-align: bottom;
                             margin-right: 0.2em;
                         }

                         .task-list-item {
                             margin-left: 0;
                         }
                     }

                    ol, ul {
                        margin: 0;
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

                code {
                    padding: 2px 4px;
                    margin: 0 4px;
                    color: #3d6983;
                    background: #eaf1f5;
                    border-radius: 3px;
                }

                pre {
                    padding: 12px 16px;
                    border: 1px solid #eeeeee;
                    background: #fafafa;
                    overflow-x: auto;

                    code {
                        margin: 0;
                        padding: 0;
                        background: transparent;
                    }
                }

                iframe {
                    border: none;
                }

                .table-container {
                    width: 100%;
                    overflow-x: auto;
                }

                table {
                    border-top: 1px solid #e5e5e5;
                    border-left: 1px solid #e5e5e5;
                    border-collapse: collapse;
                    text-align: left;
                    min-width: 100%;

                    th, td {
                        border-right: 1px solid #eeeeee;
                        border-bottom: 1px solid #eeeeee;
                        padding: 8px 16px;
                        word-wrap: normal;
                        word-break: keep-all;
                        white-space: nowrap;

                        &:last-of-type {
                            border-right-color: #e5e5e5;
                        }
                    }

                    tr:last-child {
                        th, td {
                            border-bottom-color: #e5e5e5;
                        }
                    }

                    thead {
                        background: #fafafa;
                        color: #757575;
                    }

                    tbody {
                        background: #ffffff;
                    }
                }

                .MathJax_SVG {
                    outline: none;
                }
            }
        }
    }
</style>
