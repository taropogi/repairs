import { createRouter, createWebHistory } from "vue-router";

import loginPage from "./components/pages/loginPage.vue";
import registerPage from "./components/pages/registerPage.vue";
import cpoPage from "./components/pages/cpoPage.vue";
import notFoundPage from "./components/pages/notFoundPage.vue";
import encodeCpoForm from "./components/CPO/encodeCpoForm.vue";
import searchCpoHeader from "./components/CPO/searchCpoHeader.vue";
import editCpoHeader from "./components/CPO/editCpoHeader.vue";
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
            redirect: { name: "search-cpo" },
            children: [
                {
                    path: "encode",
                    component: encodeCpoForm,
                    name: "encode-cpo",
                },
                {
                    path: "search",
                    component: searchCpoHeader,
                    name: "search-cpo",
                },
                {
                    path: "edit/:id",
                    component: editCpoHeader,
                    name: "edit-cpo",
                    props: true,
                },
            ],
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
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        }

        return {
            top: 0,
            left: 0,
        };
    },
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
        //else
        next();
    }
});

export default router;
