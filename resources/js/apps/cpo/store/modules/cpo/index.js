import mutations from "./mutations.js";
import getters from "./getters.js";
import actions from "./actions.js";

const cpoModule = {
    namespaced: true,
    state() {
        return {
            cpoHeaders: [],
            editingHeaderId: null, // what is currently editing cpo header
            editingHeaderRow: [], // what is currently editing cpo header, actual row from database
            genLinks: [],
            selectedPos: [],
            deletedCpos: [],
        };
    },
    mutations,
    getters,
    actions,
};

export default cpoModule;
