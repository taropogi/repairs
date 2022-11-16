<template>
    <div class="min-vh-100 sticky-top my-5">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="#" class="nav-link active" aria-current="page">
                    Search CPO
                </a>
            </li>
            <li>
                <a href="#" class="nav-link text-white"> Dashboard </a>
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
