import { createRouter, createWebHistory } from "vue-router";

import loginPage from "./components/pages/loginPage.vue";
import registerPage from "./components/pages/registerPage.vue";
import cpoPage from "./components/pages/cpoPage.vue";
import notFoundPage from "./components/pages/notFoundPage.vue";
import store from "./store";

const router = createRouter({
    history: createWebHistory(), // manage the history, using crateWebHistory means using the default browser history management
    routes: [
        {
            path: "/repairs",
            redirect: { name: "login-page" },
        },
        {
            path: "/repairs/cpo",
            component: cpoPage,
            name: "cpo-page",
            meta: {
                requiresAuth: true,
            },
        },

        {
            path: "/repairs/login",
            component: loginPage,
            name: "login-page",
            meta: {
                requiresUnAuth: true,
            },
        },
        {
            path: "/repairs/register",
            component: registerPage,
            name: "register-page",
            meta: {
                requiresUnAuth: true,
            },
        },
        {
            path: "/:notFound(.*)",
            component: notFoundPage,
        },
    ],
});

router.beforeEach(function (to, from, next) {
    if (to.meta.requiresAuth && !store.getters["auth/isLoggedIn"]) {
        next({
            name: "login-page",
        });
    } else if (to.meta.requiresUnAuth && store.getters["auth/isLoggedIn"]) {
        next({
            name: "cpo-page",
        });
    } else {
        next();
    }
});

export default router;
