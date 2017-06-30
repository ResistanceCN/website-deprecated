import "./setup";

import Vue from "vue";

import VueMaterial from 'vue-material';
import 'vue-material/dist/vue-material.css';

Vue.use(VueMaterial);
Vue.material.registerTheme({
    default: {
        primary: {
            color: 'blue',
            hue: 700
        },
        accent: "pink",
        warn: "red"
    }
});

import VueRouter from "vue-router";
Vue.use(VueRouter);

import App from "./App.vue";
import routes from "./routes";

let router = new VueRouter({
    mode: "history",
    routes
});

new Vue({
    el: "#app",
    render: h => h(App),
    router
});
