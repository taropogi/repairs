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
                                        name="username"
                                        v-model="loginFormData.username"
                                        required
                                        autocomplete="username"
                                        autofocus
                                    />

                                    <span class="invalid-feedback" role="alert">
                                        <strong>Error Message</strong>
                                    </span>
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
                                        name="password"
                                        v-model="loginFormData.password"
                                        required
                                        autocomplete="current-password"
                                    />

                                    <span class="invalid-feedback" role="alert">
                                        <strong>Error Message</strong>
                                    </span>
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
                                        type="submit"
                                        class="btn btn-primary"
                                    >
                                        Login
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
        };
    },
    methods: {
        submitLoginForm() {
            axios.get("/repairs/sanctum/csrf-cookie").then((response) => {
                axios
                    .post("/repairs/api/login", this.loginFormData)
                    .then((response) => {
                        this.$store.commit("auth/setIsLoggedIn", true);
                        this.$store.commit("auth/setUser", response.data);
                        //  console.log(response.data);
                        this.$router.push({
                            name: "cpo-page",
                        });
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            });
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
};
</script>

<style></style>
