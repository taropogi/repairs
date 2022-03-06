<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
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

                    <li class="nav-item">
                        <router-link :to="loginPageLink" class="nav-link"
                            >Login</router-link
                        >
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/"
                            >Welcome</router-link
                        >
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" :to="homePageLink"
                            >Home</router-link
                        >
                    </li>

                    <li class="nav-item">
                        <router-link class="nav-link" :to="registerPageLink"
                            >Register</router-link
                        >
                    </li>

                    <li class="nav-item dropdown">
                        <a
                            id="navbarDropdown"
                            class="nav-link dropdown-toggle"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            Richard
                        </a>

                        <div
                            class="dropdown-menu dropdown-menu-end"
                            aria-labelledby="navbarDropdown"
                        >
                            <a
                                class="dropdown-item"
                                href="/logout"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                            >
                                Logout
                            </a>

                            <form
                                id="logout-form"
                                action="/logout"
                                method="POST"
                                class="d-none"
                            ></form>
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
        homePageLink() {
            return {
                name: "home-page",
            };
        },
    },
};
</script>
