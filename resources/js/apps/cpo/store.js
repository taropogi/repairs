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
            genLinks: [],
            laravelData: null,
        };
    },
    mutations: {
        setMainPageTitleHeader(state, payload) {
            state.mainPageTitleHeader = payload;
        },
        setLaravelData(state, payload) {
            state.laravelData = payload;
        },
    },
    getters: {
        mainPageTitleHeader(state) {
            return state.mainPageTitleHeader;
        },
        laravelData(state) {
            return state.laravelData;
        },
    },
});

export default store;
