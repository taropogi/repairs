<template>
    <nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                Repairs System
                <span v-if="mainPageHeader"
                    >/ <strong>{{ mainPageHeader }}</strong></span
                >
            </a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto"></ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->

                    <auth-links
                        v-if="!loggedUser"
                        :login-page-link="loginPageLink"
                        :register-page-link="registerPageLink"
                    ></auth-links>
                    <admin-nav-links
                        v-if="userIsAdmin"
                        :user="loggedUser"
                        :search-cpo-page-link="searchCpoPageLink"
                        :encode-cpo-page-link="encodeCpoPageLink"
                        @log-out="logOut"
                    ></admin-nav-links>
                    <user-nav-links
                        v-if="userIsUser"
                        :user="loggedUser"
                        :search-cpo-page-link="searchCpoPageLink"
                        :encode-cpo-page-link="encodeCpoPageLink"
                        @log-out="logOut"
                    ></user-nav-links>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import adminNavLinks from "../admin/NavLinks/NavLinks.vue";
import userNavLinks from "./navLinks.vue";
import AuthLinks from "./AuthLinks.vue";

export default {
    components: {
        adminNavLinks,
        userNavLinks,
        AuthLinks,
    },
    computed: {
        userIsAdmin() {
            return this.loggedUser && this.loggedUser.is_admin;
        },
        userIsUser() {
            return this.loggedUser && !this.loggedUser.is_admin;
        },
        mainPageHeader() {
            return this.$store.getters.mainPageTitleHeader;
        },
        loginPageLink() {
            return {
                name: "login-page",
            };
        },
        registerPageLink() {
            return {
                name: "register-page",
            };
        },
        cpoPageLink() {
            return {
                name: "cpo-page",
            };
        },
        encodeCpoPageLink() {
            return {
                name: "encode-cpo",
            };
        },
        searchCpoPageLink() {
            return {
                name: "search-cpo",
            };
        },

        isLoggedIn() {
            // return false;
            return this.$store.getters["auth/isLoggedIn"];
        },
        loggedUser() {
            return this.$store.getters["auth/loggedUser"];
        },
    },
    methods: {
        logOut() {
            axios.post("/repairs/api/logout").then((response) => {
                //console.log(response);
                this.$store.commit("auth/setIsLoggedIn", false);
                this.$store.commit("auth/setUser", null);

                this.$router.push({
                    name: "login-page",
                });
            });
        },
    },
};
</script>
