import { createRouter, createWebHistory } from "vue-router";

import loginPage from "./components/pages/loginPage.vue";
import registerPage from "./components/pages/registerPage.vue";
import cpoPage from "./components/pages/cpoPage.vue";
import notFoundPage from "./components/pages/notFoundPage.vue";
import encodeCpoForm from "./components/CPO/encodeCpoForm.vue";
import searchCpoHeader from "./components/CPO/searchCpoHeader.vue";
import editCpo from "./components/EditCpo/editCpo.vue";
import AdminPage from "./components/admin/AdminPage/AdminPage.vue";
import store from "./store";

const router = createRouter({
    history: createWebHistory(), // manage the history, using crateWebHistory means using the default browser history management
    routes: [
        {
            path: "/repairs",
            redirect: { name: "login-page" },
        },
        // {
        //     path: "/",
        //     redirect: { name: "login-page" },
        // },
        // {
        //     path: "/repairs/admin",
        //     redirect: { name: "login-page" },
        // },

        {
            path: "/repairs/admin",
            component: AdminPage,
            name: "admin-page",
            redirect: { name: "admin-search-cpo" },
            meta: {
                requiresAuth: true,
                forAdmin: true,
            },
            children: [
                {
                    path: "cpo/encode",
                    component: encodeCpoForm,
                    name: "admin-encode-cpo",
                },
                {
                    path: "cpo/search",
                    component: searchCpoHeader,
                    name: "admin-search-cpo",
                },
                {
                    path: "cpo/edit/:id",
                    component: editCpo,
                    name: "admin-edit-cpo",
                    props: true,
                },
            ],
        },

        {
            path: "/repairs/user/cpo",
            component: cpoPage,
            name: "cpo-page",
            meta: {
                requiresAuth: true,
            },
            redirect: { name: "search-cpo" },
            children: [
                {
                    path: "edit/:id",
                    component: editCpo,
                    name: "edit-cpo",
                    props: true,
                },
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
        // {
        //     path: "/repairs/register",
        //     component: registerPage,
        //     name: "register-page",
        //     meta: {
        //         requiresUnAuth: true,
        //     },
        // },
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
    // console.log(from, to);
    if (to.meta.requiresAuth && !store.getters["auth/isLoggedIn"]) {
        //1
        next({
            name: "login-page",
        });
    } else if (to.meta.requiresUnAuth && store.getters["auth/isLoggedIn"]) {
        if (store.getters["auth/loggedUser"].is_admin) {
            next({
                name: "admin-page",
            });
        }

        next({
            name: "cpo-page",
        });
    } else if (to.meta.requiresAuth && store.getters["auth/isLoggedIn"]) {
        if (!to.meta.forAdmin && store.getters["auth/loggedUser"].is_admin) {
            next({
                name: "admin-page",
            });
        } else if (
            to.meta.forAdmin &&
            !store.getters["auth/loggedUser"].is_admin
        ) {
            next({
                name: "cpo-page",
            });
        }
        next();
    } else {
        //else
        next();
    }
});

export default router;
