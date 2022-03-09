import { createStore } from "vuex";

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
    mutations: {
        setIsLoggedIn(state, payload) {
            state.isLoggedIn = payload;
            localStorage.setItem("isLoggedIn", payload);
        },
        setUser(state, user) {
            state.user = user;
        },
    },
    getters: {
        loggedUser(state) {
            return state.user;
        },
        isLoggedIn(state) {
            return state.isLoggedIn;
        },
    },
};

const store = createStore({
    modules: {
        auth: authModule,
    },
    state() {
        return {
            mainPageTitleHeader: "",
        };
    },
    mutations: {
        setMainPageTitleHeader(state, payload) {
            state.mainPageTitleHeader = payload;
        },
    },
    getters: {
        mainPageTitleHeader(state) {
            return state.mainPageTitleHeader;
        },
    },
});

export default store;
