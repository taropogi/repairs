<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
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
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto"></ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->

                    <li class="nav-item" v-if="!isLoggedIn">
                        <router-link :to="loginPageLink" class="nav-link"
                            >Login</router-link
                        >
                    </li>

                    <li class="nav-item" v-if="loggedUser">
                        <router-link class="nav-link" :to="cpoPageLink"
                            >CPO</router-link
                        >
                    </li>

                    <li class="nav-item" v-if="!isLoggedIn">
                        <router-link class="nav-link" :to="registerPageLink"
                            >Register</router-link
                        >
                    </li>

                    <li class="nav-item dropdown" v-if="loggedUser">
                        <a
                            id="navbarDropdown"
                            class="nav-link dropdown-toggle"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            {{ loggedUser.name }}
                        </a>

                        <div
                            class="dropdown-menu dropdown-menu-end"
                            aria-labelledby="navbarDropdown"
                        >
                            <a href="#" class="nav-link" @click.prevent="logout"
                                >Logout</a
                            >
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    computed: {
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

        isLoggedIn() {
            // return false;
            return this.$store.getters["auth/isLoggedIn"];
        },
        loggedUser() {
            return this.$store.getters["auth/loggedUser"];
        },
    },
    methods: {
        logout() {
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
