import _ from "lodash";

const state = {
    headerType: "default",
};

const getters = {};

const actions = {};

const mutations = {
    SET_HEADER_TYPE (state, type) {
        if (!type || !_.isString(type))
            type = "default";

        state.headerType = type
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}
