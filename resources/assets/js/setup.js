import _ from "lodash";
window._ = _;

import Axios from "axios";
window.Axios = Axios;

Axios.defaults.headers.common["Authorization"] = "Bearer " + window.localStorage.userToken;

import Vue from "vue";

import VueMaterial from 'vue-material';
import 'vue-material/dist/vue-material.css';
import  themes from "./setup/themes"

Vue.use(VueMaterial);
Vue.material.registerTheme(themes);

import VueRouter from "vue-router";
Vue.use(VueRouter);

import routes from "./setup/routes";

export const router = new VueRouter({
    mode: "history",
    routes
});

import Vuex from "vuex"
Vue.use(Vuex);

import * as actions from "./vuex/actions"
import * as getters from "./vuex/getters"
import ui from "./vuex/modules/ui";
import auth from "./vuex/modules/auth";

export const store = new Vuex.Store({
    actions: actions.default,
    getters: getters.default,
    modules: {
        ui,
        auth
    },
    strict: process.env.NODE_ENV !== "production"
});
