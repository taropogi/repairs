<template>
    <div class="min-vh-100 sticky-top d-flex flex-column" v-if="isLoggedIn">
        <h2 class="text-white mt-5 mb-0">Menu</h2>
        <hr class="text-white" />
        <ul class="nav nav-pills flex-column mb-auto my-2">
            <li class="nav-item">
                <router-link
                    :to="searchCpoLink"
                    class="nav-link text-white"
                    :class="{ active: isNavSearchActive }"
                    >Search CPO
                </router-link>
            </li>
            <li>
                <router-link
                    :to="encodeCpoPageLink"
                    class="nav-link text-white"
                    :class="{ active: isNavEncodeActive }"
                    >Encode CPO</router-link
                >
            </li>
            <li>
                <router-link
                    :to="linkExportCpo"
                    class="nav-link text-white"
                    :class="{ active: isNavExportActive }"
                    >Export CPO list</router-link
                >
            </li>
        </ul>

        <hr />

        <user-options @logOut="logOut"></user-options>
    </div>
</template>

<script>
import UserOptions from "./UserOptions.vue";
export default {
    components: {
        UserOptions,
    },
    computed: {
        activeNav() {
            return this.$store.getters.activeNav;
        },
        isNavSearchActive() {
            if (this.activeNav && this.activeNav.nav === "search-cpo") {
                return true;
            }
            return false;
        },
        isNavExportActive() {
            if (this.activeNav && this.activeNav.nav === "export-cpo") {
                return true;
            }
            return false;
        },
        isNavEncodeActive() {
            if (this.activeNav && this.activeNav.nav === "encode-cpo") {
                return true;
            }
            return false;
        },
        userIsAdmin() {
            return (
                this.isLoggedIn && this.loggedUser && this.loggedUser.is_admin
            );
        },
        userIsUser() {
            return (
                this.isLoggedIn && this.loggedUser && !this.loggedUser.is_admin
            );
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
        linkExportCpo() {
            if (this.$store.getters["auth/loggedUser"].is_admin) {
                return {
                    name: "admin-export-cpo-list",
                };
            }

            return {
                name: "export-cpo-list",
            };
        },
        encodeCpoPageLink() {
            if (this.$store.getters["auth/loggedUser"].is_admin) {
                return { name: "admin-encode-cpo" };
            }
            return { name: "encode-cpo" };
        },
        searchCpoLink() {
            if (this.$store.getters["auth/loggedUser"].is_admin) {
                return { name: "admin-search-cpo" };
            }
            return { name: "search-cpo" };
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
            axios.post("api/logout").then((response) => {
                // console.log(response.data);
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
