<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>

                    <div class="card-body">
                        <form
                            method="POST"
                            action="#"
                            @submit.prevent="submitLoginForm"
                        >
                            <div class="row mb-3">
                                <label
                                    for="username"
                                    class="col-md-4 col-form-label text-md-end"
                                    >Username</label
                                >

                                <div class="col-md-6">
                                    <input
                                        id="username"
                                        type="text"
                                        class="form-control"
                                        :class="inputValidClasses"
                                        name="username"
                                        v-model="loginFormData.username"
                                        required
                                        autocomplete="username"
                                        autofocus
                                    />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label
                                    for="password"
                                    class="col-md-4 col-form-label text-md-end"
                                    >Password</label
                                >

                                <div class="col-md-6">
                                    <input
                                        id="password"
                                        type="password"
                                        class="form-control"
                                        :class="inputValidClasses"
                                        name="password"
                                        v-model="loginFormData.password"
                                        required
                                        autocomplete="current-password"
                                    />
                                </div>
                            </div>

                            <div class="row m-0" v-if="showError">
                                <div class="col-md-6 offset-md-4">
                                    <div
                                        class="alert alert-danger d-flex align-items-center p-2"
                                        role="alert"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="24"
                                            height="24"
                                            fill="currentColor"
                                            class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"
                                            viewBox="0 0 16 16"
                                            role="img"
                                            aria-label="Warning:"
                                        >
                                            <path
                                                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"
                                            />
                                        </svg>
                                        <div>Invalid login</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="remember"
                                            id="remember"
                                        />

                                        <label
                                            class="form-check-label"
                                            for="remember"
                                        >
                                            Remember me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button
                                        v-if="!isValidating"
                                        type="submit"
                                        class="btn btn-primary"
                                    >
                                        Login
                                    </button>

                                    <button
                                        v-else
                                        class="btn btn-primary"
                                        type="button"
                                        disabled
                                    >
                                        <span
                                            class="spinner-border spinner-border-sm"
                                            role="status"
                                            aria-hidden="true"
                                        ></span>
                                        Loading...
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loginFormData: {
                username: "",
                password: "",
            },
            isValidating: false,
            isError: false,
        };
    },

    methods: {
        submitLoginForm() {
            this.isValidating = true;
            axios.get("/repairs/sanctum/csrf-cookie").then((response) => {
                // console.log(response);
                axios
                    .post("/repairs/api/login", this.loginFormData, {
                        headers: {
                            Accept: `application/json`,
                        },
                    })
                    .then((response) => {
                        console.log(response.data);
                        this.$store.commit("auth/setIsLoggedIn", true);
                        this.$store.commit("auth/setUser", response.data);

                        this.$router.push({
                            name: this.redirectLink,
                        });
                    })
                    .catch((error) => {
                        this.isValidating = false;
                        this.isError = true;
                        // console.log("error here");
                        console.log(error.response.data.message);
                    });
            });
        },
    },
    computed: {
        redirectLink() {
            if (this.$store.getters["auth/loggedUser"].is_admin) {
                return "admin-search-cpo";
            }

            return "cpo-page";
        },
        inputValidClasses() {
            return {
                "is-invalid": this.showError,
            };
        },
        showError() {
            return this.isError && !this.isValidating;
        },
    },
    created() {
        /*
        if (this.$store.getters["auth/isLoggedIn"]) {
            this.$router.replace({
                name: "cpo-page",
            });
        }
        */
    },
    beforeCreate() {
        this.$store.commit("setMainPageTitleHeader", "Login");
    },
    mounted() {
        // console.log(this.inputValidClasses);
    },
};
</script>

<style></style>
