import _ from "lodash";
window._ = _;

import axios from "axios";
window.axios = axios;

axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
axios.defaults.headers.common["X-CSRF-TOKEN"] = window.Laravel.csrfToken;
