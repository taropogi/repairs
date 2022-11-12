<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>

                    <div class="card-body">
                        <form @submit.prevent="submitRegisterForm">
                            <div class="row mb-3">
                                <label
                                    for="name"
                                    class="col-md-4 col-form-label text-md-end"
                                    >Name</label
                                >

                                <div class="col-md-6">
                                    <input
                                        id="name"
                                        type="text"
                                        class="form-control"
                                        name="name"
                                        v-model="formData.name"
                                        required
                                        autocomplete="name"
                                        autofocus
                                    />

                                    <span class="invalid-feedback" role="alert">
                                        <strong>Error here</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label
                                    for="email"
                                    class="col-md-4 col-form-label text-md-end"
                                    >Username</label
                                >

                                <div class="col-md-6">
                                    <input
                                        id="username"
                                        type="text"
                                        class="form-control"
                                        :class="{
                                            'is-invalid': isUsernameInvalid,
                                        }"
                                        name="username"
                                        v-model="formData.username"
                                        required
                                        autocomplete="username"
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
                                        v-model="formData.password"
                                        class="form-control"
                                        :class="{
                                            'is-invalid': isPasswordInValid,
                                        }"
                                        name="password"
                                        required
                                        autocomplete="new-password"
                                    />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label
                                    for="confirm_password"
                                    class="col-md-4 col-form-label text-md-end"
                                    >Confirm Password</label
                                >

                                <div class="col-md-6">
                                    <input
                                        id="confirm_password"
                                        v-model="formData.password_confirmation"
                                        type="password"
                                        class="form-control"
                                        :class="{
                                            'is-invalid': isPasswordInValid,
                                        }"
                                        name="password_confirmation"
                                        required
                                        autocomplete="new-password"
                                    />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="is-admin"
                                            v-model="formData.isAdmin"
                                        />
                                        <label
                                            class="form-check-label"
                                            for="is-admin"
                                        >
                                            Admin
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div v-if="formErrors">
                                <ul>
                                    <li
                                        class="text-danger"
                                        v-for="(ErrorValue, key) in formErrors"
                                        :key="
                                            'register-error' + ErrorValue + key
                                        "
                                    >
                                        <strong> {{ key }} </strong> -
                                        {{ ErrorValue }}
                                    </li>
                                </ul>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >
                                        Register
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
            formData: {
                name: "",
                username: "",
                password: "",
                password_confirmation: "",
                isAdmin: false,
            },
            formErrors: null,
        };
    },
    computed: {
        isUsernameInvalid() {
            if (this.formErrors && this.formErrors.username) {
                return true;
            }
            return false;
        },

        isPasswordInValid() {
            if (this.formErrors && this.formErrors.password) {
                return true;
            }
            return false;
        },
    },
    methods: {
        async submitRegisterForm() {
            console.log(this.formData);
            this.formErrors = null;
            await axios
                .post("api/register", this.formData)
                .then((response) => {
                    // console.log(response.data.req);
                    if (response.data.errors) {
                        this.formErrors = response.data.errors;
                        // console.log(this.formErrors);
                    } else {
                        this.$router.push({
                            name: "admin-user-search",
                        });
                    }

                    // console.log(response.data.errors);
                })
                .catch((error) => {
                    console.log("errors");
                    console.log(error);
                });
        },
    },
    beforeCreate() {
        this.$store.commit("setMainPageTitleHeader", "Register");
    },
};
</script>

<style></style>
