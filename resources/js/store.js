import { createStore } from "vuex";
import authModule from "./store/modules/auth/index.js";
import cpoModule from "./store/modules/cpo/index.js";

const store = createStore({
    modules: {
        auth: authModule,
        cpo: cpoModule,
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
