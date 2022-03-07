<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>

                    <div class="card-body">
                        <form
                            method="POST"
                            action="#"
                            @submit.prevent="submitRegisterForm"
                        >
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
                                    >Email Address</label
                                >

                                <div class="col-md-6">
                                    <input
                                        id="email"
                                        type="email"
                                        class="form-control"
                                        name="email"
                                        v-model="formData.email"
                                        required
                                        autocomplete="email"
                                    />

                                    <span class="invalid-feedback" role="alert">
                                        <strong>Error here</strong>
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
                                        v-model="formData.password"
                                        class="form-control"
                                        name="password"
                                        required
                                        autocomplete="new-password"
                                    />

                                    <span class="invalid-feedback" role="alert">
                                        <strong>Error here</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label
                                    for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end"
                                    >Confirm Password</label
                                >

                                <div class="col-md-6">
                                    <input
                                        id="password-confirm"
                                        v-model="formData.password_confirm"
                                        type="password"
                                        class="form-control"
                                        name="password_confirmation"
                                        required
                                        autocomplete="new-password"
                                    />
                                </div>
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
                email: "",
                password: "",
                password_confirm: "",
            },
        };
    },
    methods: {
        submitRegisterForm() {
            alert("submitted form!");
        },
    },
};
</script>

<style></style>
