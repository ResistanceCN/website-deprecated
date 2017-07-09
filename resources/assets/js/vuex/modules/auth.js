import Axios from 'axios';

// user: [{ id, name }]
const state = {
    googleUser: {},
    user: {},
    token: window.localStorage.userToken
};

const getters = {};

const actions = {
    checkUser ({ state, commit, rootState }) {
        if (!state.token)
            return;

        let Authorization = "Bearer " + state.token;

        Axios.get('/api/user', {
            headers: { Authorization }
        }).then(response => {
            Axios.defaults.headers.common["Authorization"] = Authorization;

            commit("LOGIN_SUCCESS", {
                user: response.data,
                token: state.token
            });
        }).catch(error => {
            commit("LOGIN_ERROR");
        });
    }
};

const mutations = {
    GOOGLE_SIGN_IN (state, googleUser) {
        state.googleUser = googleUser
    },
    LOGIN_SUCCESS (state, payload) {
        state.user = payload.user;

        if (payload.token === "null" || payload.token === null)
            payload.token = "";

        window.localStorage.userToken = state.token = payload.token;
    },
    LOGIN_ERROR (state) {
        state.user = {};
        window.localStorage.userToken = state.token = "";
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}
