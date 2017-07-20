<template>
    <div id="page-form" class="content-wrapper">
        <div class="ribbon"></div>

        <div class="container container-stretch form-container">
            <md-card>
                <md-card-header>
                    <div class="md-title">{{ form.title }}</div>
                </md-card-header>

                <md-card-content v-if="answered && !edit">
                    <p>You have been submitted the form.</p>
                    <md-button class="md-raised md-primary" @click="edit = true">Edit your answer</md-button>
                </md-card-content>

                <md-card-content v-else>
                    <form @submit.stop.prevent="submit">
                        <template v-if="ready" v-for="(question, name) in questions">
                            <!-- text -->
                            <md-input-container
                                    :id="'question-' + name"
                                    v-if="question.type == 'text'"
                                    :class="{
                                        'md-input-invalid': errors[name],
                                        'md-input-required': question.required
                                    }">
                                <label>{{ question.title }}</label>
                                <md-textarea
                                        :name="name"
                                        v-model="answer[name]"
                                        @input="$delete(errors, name)"></md-textarea>
                                <span class="md-error" v-show="errors[name]">{{ errors[name] }}</span>
                            </md-input-container>

                            <!-- email -->
                            <md-input-container
                                    :id="'question-' + name"
                                    v-if="question.type == 'email'"
                                    :class="{
                                        'md-input-invalid': errors[name],
                                        'md-input-required': question.required
                                    }">
                                <label>{{ question.title }}</label>
                                <md-input
                                        type="email"
                                        :name="name"
                                        v-model="answer[name]"
                                        @input="$delete(errors, name)"></md-input>
                                <span class="md-error" v-show="errors[name]">{{ errors[name] }}</span>
                            </md-input-container>

                            <!-- description -->
                            <p v-if="question.type == 'description'">
                                {{ question.title }}
                            </p>

                            <!-- radio -->
                            <div :id="'question-' + name" v-if="question.type == 'radio'" class="input-container">
                                <label :class="{ 'label-error': errors[name] }">{{ question.title }}</label>
                                <span class="error" v-show="errors[name]">{{ errors[name] }}</span>
                                <div class="checkboxes">
                                    <md-radio
                                            v-for="(option, id) in question.options"
                                            :key="id"
                                            :name="name"
                                            :mdValue="id"
                                            v-model="answer[name]"
                                            @input="$delete(errors, name)">{{ option }}</md-radio>
                                </div>
                            </div>

                            <!-- select -->
                            <div :id="'question-' + name" v-if="question.type == 'select'" class="input-container">
                                <label :class="{ 'label-error': errors[name] }">{{ question.title }}</label>
                                <span class="error" v-show="errors[name]">{{ errors[name] }}</span>
                                <div class="checkboxes">
                                    <md-checkbox
                                            v-for="(option, id) in question.options"
                                            :key="id"
                                            :name="name"
                                            :value="id"
                                            v-model="answer[name][id]"
                                            @input="$delete(errors, name)">{{ option }}</md-checkbox>
                                </div>
                            </div>

                            <!-- map -->
                            <div :id="'question-' + name" v-if="question.type == 'map'" class="input-container">
                                <label :class="{ 'label-error': errors[name] }">{{ question.title }}</label>
                                <span class="error" v-show="errors[name]">{{ errors[name] }}</span>
                                <div class="locations">
                                    <md-chip
                                            v-for="(location, id) in answer[name]"
                                            :key="id"
                                            md-deletable
                                            @delete="removeLocation(id, answer[name])">{{ location }}</md-chip>
                                </div>
                                <region-map
                                        :geojson="question.geojson"
                                        @select="addLocation($event, answer[name]), $delete(errors, name)"></region-map>
                            </div>
                        </template>

                        <md-button type="submit" class="md-raised md-primary" id="btn-submit">Submit</md-button>
                    </form>
                </md-card-content>
            </md-card>
        </div>
    </div>
</template>

<script>
    import _ from "lodash";
    import Axios from "axios";
    import RegionMap from "../components/RegionMap.vue";

    export default {
        components: {
            RegionMap
        },
        data () {
            return {
                ready: false,
                form: {},
                errors: {},
                answer: {},
                edit: false
            }
        },
        computed: {
            name () {
                return this.$route.params.name;
            },
            questions () {
                return this.form.questions ? JSON.parse(this.form.questions) : {};
            },
            answered () {
                return _.isEmpty(this.form) ? false : this.form.answer !== null;
            }
        },
        created () {
            this.$store.commit("SET_HEADER_TYPE", "article");
            this.getForm();
        },
        beforeRouteUpdate (to, from, next) {
            this.getForm();
            next();
        },
        beforeRouteLeave (to, from, next) {
            this.$store.commit("SET_HEADER_TYPE", "default");
            next();
        },
        methods: {
            getForm () {
                Axios.get("/api/form/" + this.name).then(response => {
                    this.form = response.data;

                    let answer;

                    if (response.data.answer === null) {
                        answer = {};
                    } else {
                        answer = JSON.parse(response.data.answer.answers);
                    }

                    Object.keys(this.questions).forEach(name => {
                        let question = this.questions[name];

                        if (question.type === "select") {
                            let idArray = answer[name];
                            answer[name] = {};

                            if (Array.isArray(idArray))
                                idArray.forEach(id => {
                                    answer[name][id] = question.options[id]
                                });
                            else
                                Object.keys(question.options).forEach(id => {
                                    answer[name][id] = false;
                                });
                        } else if (question.type === "map") {
                            let idArray = answer[name];
                            answer[name] = {};

                            if (Array.isArray(idArray)) {
                                let options = {};
                                question.geojson.features.forEach(feature => {
                                    options[feature.properties.id] = feature.properties.name;
                                });

                                idArray.forEach(id => {
                                    answer[name][id] = options[id]
                                });
                            }
                        } else if (question.type !== "description") {
                            answer[name] = answer[name] || "";
                        }
                    });

                    this.answer = answer;
                    this.ready = true;
                }).catch(error => {
                    console.log(error);
                    // this.$router.back();
                });
            },
            addLocation (event, locations) {
                this.$set(locations, event.feature.getProperty("id"), event.feature.getProperty("name"));
            },
            removeLocation (id, locations) {
                this.$delete(locations, id);
            },
            prepareData (answer) {
                let data = {};

                Object.keys(answer).forEach(name => {
                    if (_.isString(answer[name])) {
                        data[name] = answer[name].toString();
                    } else if (_.isObject(answer[name])) {
                        data[name] = [];

                        Object.keys(answer[name]).forEach(key => {
                            if (answer[name][key])
                                data[name].push(key);
                        });

                        data[name].sort();
                    }

                    if (_.isEmpty(data[name])) {
                        delete data[name];

                        if (this.questions[name].required)
                            this.$set(this.errors, name, "The field is required.");
                        else
                            this.$delete(this.errors, name);
                    }
                });

                return data;
            },
            scrollToFirstError () {
                let name = Object.keys(this.errors)[0];

                document.getElementById("question-" + name)
                    .scrollIntoView({
                        behavior: 'smooth'
                    });
            },
            submit () {
                let answer = this.prepareData(this.answer);

                if (!_.isEmpty(this.errors))
                    return this.scrollToFirstError();

                Axios.put("/api/form/" + this.name + "/answer", answer).then(response => {
                    //
                }).catch(error => {
                    let errors = error.response.data;
                    this.errors = {};

                    Object.keys(errors).forEach(name => {
                        this.errors[name] = errors[name][0].replace(name + " ", "");
                    });

                    this.scrollToFirstError();
                });
            }
        }
    }
</script>

<style lang="scss">
    .form-container {
        .md-card {
            margin-bottom: 60px;

            .md-card-content {
                .checkboxes {
                    display: flex;
                    flex-direction: row;
                    flex-wrap: wrap;

                    .md-radio-container {
                        flex-shrink: 0;
                    }

                    .md-checkbox, .md-radio {
                        display: flex;
                        min-width: 50%;
                        margin-bottom: 0;
                        margin-right: 0;
                        padding-right: 8px;
                    }

                    .md-checkbox-label, .md-radio-label {
                        height: auto;
                    }
                }
            }
        }

        p {
            font-size: 16px;
            margin: 4px 0 24px;
            padding-top: 16px;
            line-height: 20px;
        }
        
        .input-container {
            margin: 4px 0 24px;
            padding-top: 16px;

            .locations {
                margin: 16px 0 8px;

                .md-chip {
                    margin: 0 8px 8px 0;
                }
            }

            .label-error, .error {
                color: #f44336;
            }

            .error {
                color: #f44336;
                height: 20px;
                font-size: 12px;
                margin-left: 8px;
            }
        }
    }
</style>
