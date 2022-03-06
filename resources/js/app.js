require("./bootstrap");

import { createApp } from "vue";
import { createRouter, createWebHistory } from "vue-router";

import App from "./components/App.vue";
import welcomePage from "./components/pages/welcomePage.vue";
import homePage from "./components/pages/homePage.vue";
import loginPage from "./components/pages/loginPage.vue";
import registerPage from "./components/pages/registerPage.vue";

const router = createRouter({
    history: createWebHistory(), // manage the history, using crateWebHistory means using the default browser history management
    routes: [
        {
            path: "/",
            component: welcomePage,
        },
        {
            path: "/home",
            component: homePage,
            name: "home-page",
        },
        {
            path: "/login",
            component: loginPage,
            name: "login-page",
        },
        {
            path: "/register",
            component: registerPage,
            name: "register-page",
        },
    ],
});

const app = createApp(App);

app.use(router);

app.mount("#app");
