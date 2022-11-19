import mutations from "./mutations.js";
import getters from "./getters.js";
import actions from "./actions.js";

const exportModule = {
    namespaced: true,
    state() {
        return {
            selectedStatus: [],
            cpoModifiedDate: {
                from:
                    new Date().getFullYear() +
                    "-" +
                    (Number(new Date().getMonth()) + 1) +
                    "-" +
                    new Date().getDate(),
                to:
                    new Date().getFullYear() +
                    "-" +
                    (Number(new Date().getMonth()) + 1) +
                    "-" +
                    new Date().getDate(),
            },
            cpoChangedStatusDate: {
                from:
                    new Date().getFullYear() +
                    "-" +
                    (Number(new Date().getMonth()) + 1) +
                    "-" +
                    new Date().getDate(),
                to:
                    new Date().getFullYear() +
                    "-" +
                    (Number(new Date().getMonth()) + 1) +
                    "-" +
                    new Date().getDate(),
            },
            cpoChangedStatusTo: 2,
            cpoChangedStatusCurrent: true,
            exportSearched: {
                byStatus: [],
                byModified: [],
                byChangedStatus: [],
            },
        };
    },
    mutations,
    getters,
    actions,
};

export default exportModule;
