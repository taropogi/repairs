import mutations from "./mutations.js";
import getters from "./getters.js";
import actions from "./actions.js";

const cpoModule = {
    namespaced: true,
    state() {
        return {};
    },
    mutations,
    getters,
    actions,
};

export default cpoModule;
