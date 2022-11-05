import mutations from "./mutations.js";
import getters from "./getters.js";
import actions from "./actions.js";

const authModule = {
    namespaced: true,
    state() {
        return {
            isLoggedIn:
                localStorage.getItem("isLoggedIn") &&
                localStorage.getItem("loggedUser") !== '""'
                    ? localStorage.getItem("isLoggedIn") === "true"
                        ? true
                        : false
                    : false,
            user: localStorage.getItem("loggedUser")
                ? JSON.parse(localStorage.getItem("loggedUser"))
                : null,
        };
    },
    mutations,
    getters,
    actions,
};

export default authModule;
