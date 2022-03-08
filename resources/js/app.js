require("./bootstrap");

import { createApp } from "vue";
import { createRouter, createWebHistory } from "vue-router";
import { createStore } from "vuex";

import App from "./components/App.vue";
import welcomePage from "./components/pages/welcomePage.vue";
import homePage from "./components/pages/homePage.vue";
import loginPage from "./components/pages/loginPage.vue";
import registerPage from "./components/pages/registerPage.vue";

const store = createStore({
    state() {
        return {
            user: null,
            counter: 0,
        };
    },
    mutations: {
        setUser(state, user) {
            state.user = user;
        },
        addOne(state, payload = 5) {
            state.counter = state.counter + payload;
        },
    },
    getters: {
        loggedUser(state) {
            return state.user;
        },
    },
});

const router = createRouter({
    history: createWebHistory(), // manage the history, using crateWebHistory means using the default browser history management
    routes: [
        {
            path: "/",
            redirect: { name: "welcome-page" },
        },
        {
            path: "/repairs",
            component: welcomePage,
            name: "welcome-page",
        },
        {
            path: "/repairs/home",
            component: homePage,
            name: "home-page",
        },
        {
            path: "/repairs/login",
            component: loginPage,
            name: "login-page",
        },
        {
            path: "/repairs/register",
            component: registerPage,
            name: "register-page",
        },
    ],
});

const app = createApp(App);

app.use(router);
app.use(store);

app.mount("#app");
