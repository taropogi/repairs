import mutations from "./mutations.js";
import getters from "./getters.js";
import actions from "./actions.js";

const exportModule = {
    namespaced: true,
    state() {
        return {
            selectedStatus: [],
        };
    },
    mutations,
    getters,
    actions,
};

export default exportModule;
