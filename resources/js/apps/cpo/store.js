import { createStore } from "vuex";
import authModule from "./store/modules/auth/index.js";
import cpoModule from "./store/modules/cpo/index.js";
import exportModule from "./store/modules/export/index.js";

const store = createStore({
    modules: {
        auth: authModule,
        cpo: cpoModule,
        export: exportModule,
    },
    state() {
        return {
            mainPageTitleHeader: "",
            genLinks: [],
            laravelData: null,
            activeNav: null,
            showBackDrop: false,
        };
    },
    mutations: {
        setMainPageTitleHeader(state, payload) {
            state.mainPageTitleHeader = payload;
        },
        setLaravelData(state, payload) {
            state.laravelData = payload;
        },
        setActiveNav(state, payload) {
            state.activeNav = payload;
        },
        setShowBackDrop(state, payload) {
            state.showBackDrop = payload;
        },
    },
    getters: {
        showBackDrop(state) {
            return state.showBackDrop;
        },
        mainPageTitleHeader(state) {
            return state.mainPageTitleHeader;
        },
        laravelData(state) {
            return state.laravelData;
        },
        activeNav(state) {
            return state.activeNav;
        },
    },
    actions: {
        setShowBackDrop(context, payload) {
            context.commit("setShowBackDrop", payload);
        },
        setActiveNav(context, payload) {
            context.commit("setActiveNav", payload);
        },
    },
});

export default store;
