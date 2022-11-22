<template>
    <div class="container p-5">
        <form class="row g-3" v-if="user" @submit.prevent="submitUpdateForm">
            <div class="col-md-4">
                <label for="username" class="form-label">Username</label>
                <input
                    type="text"
                    class="form-control"
                    id="username"
                    name="username"
                    v-model="user.username"
                    :class="{
                        'is-invalid': isUsernameInvalid,
                    }"
                    required
                />
            </div>
            <div class="col-md-4">
                <label for="name" class="form-label">Name</label>
                <input
                    type="text"
                    class="form-control"
                    id="name"
                    name="name"
                    v-model="user.name"
                    required
                />
            </div>

            <div class="col-md-4">
                <label for="email" class="form-label">Email</label>
                <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    v-model="user.email"
                />
            </div>

            <div class="col-md-4">
                <label for="password" class="form-label">Password</label>
                <input
                    type="password"
                    class="form-control"
                    id="password"
                    v-model="user.password"
                    :class="{
                        'is-invalid': isPasswordInValid,
                    }"
                    name="password"
                    required
                />
            </div>

            <div class="col-md-4">
                <label for="confirm_password" class="form-label"
                    >Confirm Password</label
                >
                <input
                    type="password"
                    class="form-control"
                    name="password_confirmation"
                    :class="{
                        'is-invalid': isPasswordInValid,
                    }"
                    id="confirm_password"
                    required
                    v-model="user.password_confirmation"
                />
            </div>
            <div class="col-4 d-flex align-items-center">
                <div class="form-check form-switch">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="is-admin"
                        v-model="user.is_admin"
                    />
                    <label class="form-check-label" for="is-admin">
                        Admin
                    </label>
                </div>
            </div>

            <div v-if="formErrors">
                <ul>
                    <li
                        class="text-danger"
                        v-for="(ErrorValue, key) in formErrors"
                        :key="'register-error' + ErrorValue + key"
                    >
                        <strong> {{ key }} </strong> -
                        {{ ErrorValue }}
                    </li>
                </ul>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</template>

<script>
import { mapActions } from "vuex";
export default {
    props: ["id"],
    data() {
        return {
            user: null,
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
        async getUser() {
            await axios
                .get("api/users/edit/" + this.id)
                .then((response) => {
                    // console.log(response);
                    this.user = response.data.user;
                    this.user.is_admin = this.user.is_admin === 1;
                    // console.log(this.user.is_admin);
                    // if (response.data.errors) {
                    //     this.formErrors = response.data.errors;
                    //     // console.log(this.formErrors);
                    // } else {
                    //     this.$router.push({
                    //         name: "admin-user-search",
                    //     });
                    // }

                    // console.log(response.data.errors);
                })
                .catch((error) => {
                    console.log("errors");
                    console.log(error);
                });
        },
        async submitUpdateForm() {
            // console.log(this.formData);
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
        ...mapActions(["setActiveNav"]),
    },
    beforeCreate() {
        this.$store.commit("setMainPageTitleHeader", "Register");
    },
    mounted() {
        this.getUser();
        this.setActiveNav({
            nav: "admin-user-edit",
        });
    },
};
</script>

<style></style>
