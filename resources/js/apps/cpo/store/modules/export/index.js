import mutations from "./mutations.js";
import getters from "./getters.js";
import actions from "./actions.js";

const exportModule = {
    namespaced: true,
    state() {
        return {
            selectedStatus: [],
            cpoModifiedDate: {
                from: new Date().toISOString().slice(0, 10),
                to: new Date().toISOString().slice(0, 10),
            },
        };
    },
    mutations,
    getters,
    actions,
};

export default exportModule;
