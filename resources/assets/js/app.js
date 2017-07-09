import { router, store } from "./setup";

import Vue from "vue";
import App from "./App.vue";

new Vue({
    el: "#app",
    render: h => h(App),
    router,
    store
});
