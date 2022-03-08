<template>
    <nav
        class="navbar navbar-expand-md navbar-light bg-white shadow-sm"
        v-if="!isLoading"
    >
        <div class="container">
            <a class="navbar-brand" href="#"> Repairs System </a>
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
                    <li class="nav-item" v-if="!isLoggedIn">
                        <router-link class="nav-link" to="/"
                            >Welcome</router-link
                        >
                    </li>
                    <li class="nav-item" v-if="isLoggedIn">
                        <router-link class="nav-link" :to="cpoPageLink"
                            >CPO</router-link
                        >
                    </li>
                    <li class="nav-item" v-if="isLoggedIn">
                        <router-link class="nav-link" :to="homePageLink"
                            >Home</router-link
                        >
                    </li>

                    <li class="nav-item" v-if="!isLoggedIn">
                        <router-link class="nav-link" :to="registerPageLink"
                            >Register</router-link
                        >
                    </li>

                    <li class="nav-item dropdown" v-if="isLoggedIn">
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
    data() {
        return {
            isLoading: true,
        };
    },
    computed: {
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
        homePageLink() {
            return {
                name: "home-page",
            };
        },
        isLoggedIn() {
            if (this.$store.getters.loggedUser) {
                return true;
            }
            return false;
        },
        loggedUser() {
            return this.$store.getters.loggedUser;
        },
    },
    methods: {
        logout() {
            axios.post("/repairs/api/logout").then((response) => {
                //console.log(response);
                this.$store.commit("setUser", null);
                this.$router.push({
                    name: "login-page",
                });
            });
        },
    },
    mounted() {
        this.isLoading = false;
    },
};
</script>
