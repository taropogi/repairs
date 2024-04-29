import { createRouter, createWebHistory } from "vue-router";

import loginPage from "./components/pages/loginPage.vue";
import LoginTrans from "./components/LoginScreen/LoginTrans.vue";
// import registerPage from "./components/pages/registerPage.vue";
import SearchCpo from "./components/SearchCpo/SearchCpo.vue";
import cpoPage from "./components/pages/cpoPage.vue";
import notFoundPage from "./components/pages/notFoundPage.vue";
import encodeCpoForm from "./components/CPO/encodeCpoForm.vue";
// import searchCpoHeader from "./components/CPO/searchCpoHeader.vue";
import editCpo from "./components/EditCpo/editCpo.vue";
import AdminPage from "./components/admin/AdminPage/AdminPage.vue";
import MultiChangeStatus from "./components/MultiChangeStatus/MultiChangeStatus.vue";
import ExportCpoList from "./components/ExportCpoList/ExportCpoList.vue";

//admin
import UserSearch from "./components/admin/UserPage/UserSearch.vue";
import CreateUser from "./components/admin/UserPage/CreateUser.vue";
import EditUser from "./components/admin/UserPage/EditUser.vue";
import StatusSearch from "./components/admin/StatusPage/StatusSearch.vue";
import StatusCreate from "./components/admin/StatusPage/StatusCreate.vue";

import store from "./store";

const router = createRouter({
    history: createWebHistory(), // manage the history, using crateWebHistory means using the default browser history management
    routes: [
        {
            path: "/",
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
            path: "/user/cpo",
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
                    //component: searchCpoHeader,
                    component: SearchCpo,
                    name: "search-cpo",
                },

                {
                    path: "cpos/changes-status",
                    //component: searchCpoHeader,
                    component: MultiChangeStatus,
                    name: "cpo-multi-change-status",
                },
                {
                    path: "cpos/export",
                    component: ExportCpoList,
                    name: "export-cpo-list",
                },
            ],
        },

        {
            path: "/admin",
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
                    //component: searchCpoHeader,
                    component: SearchCpo,
                    name: "admin-search-cpo",
                },
                {
                    path: "cpo/edit/:id",
                    component: editCpo,
                    name: "admin-edit-cpo",
                    props: true,
                },
                {
                    path: "cpos/export",
                    component: ExportCpoList,
                    name: "admin-export-cpo-list",
                },
                {
                    path: "user/search",
                    component: UserSearch,
                    name: "admin-user-search",
                },

                {
                    path: "user/create",
                    component: CreateUser,
                    name: "admin-user-create",
                },
                {
                    path: "user/edit/:id",
                    component: EditUser,
                    name: "admin-user-edit",
                    props: true,
                },
                {
                    path: "cpo/status/search",
                    component: StatusSearch,
                    name: "admin-status-search",
                },
                {
                    path: "cpo/status/create",
                    component: StatusCreate,
                    name: "admin-status-create",
                },
            ],
        },

        {
            path: "/login",
            component: loginPage,
            // component: LoginTrans,

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
    // console.log(store.getters);
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
        } else {
            next();
        }
    } else {
        //else
        next();
    }
});

export default router;
