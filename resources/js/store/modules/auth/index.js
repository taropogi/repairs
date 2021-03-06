import mutations from "./mutations.js";
import getters from "./getters.js";
import actions from "./actions.js";

const authModule = {
    namespaced: true,
    state() {
        return {
            isLoggedIn: localStorage.getItem("isLoggedIn")
                ? localStorage.getItem("isLoggedIn") === "true"
                    ? true
                    : false
                : false,
            user: null,
        };
    },
    mutations,
    getters,
    actions,
};

export default authModule;
