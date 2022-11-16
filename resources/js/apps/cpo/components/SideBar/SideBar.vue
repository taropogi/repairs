<template>
    <div class="min-vh-100 sticky-top d-flex flex-column">
        <ul class="nav nav-pills flex-column mb-auto my-5">
            <li class="nav-item">
                <router-link
                    :to="searchCpoLink"
                    class="nav-link text-white active"
                    >Search CPO</router-link
                >
            </li>
            <li>
                <router-link :to="encodeCpoPageLink" class="nav-link text-white"
                    >Encode CPO</router-link
                >
            </li>
            <li>
                <a href="#" class="nav-link text-white"> Orders </a>
            </li>
            <li>
                <a href="#" class="nav-link text-white"> Products </a>
            </li>
            <li>
                <a href="#" class="nav-link text-white"> Customers </a>
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
