<template>
    <form class="sticky-top bg-secondary text-white p-5 m-0">
        <div class="row">
            <div class="col">
                <label>Username</label>
                <input
                    type="text"
                    class="form-control"
                    @input="search"
                    v-model.lazy="searchCriteria.username"
                />
                <div class="form-check form-switch">
                    <input
                        v-model.lazy="searchCriteria.isAdmin"
                        class="form-check-input"
                        type="checkbox"
                        id="is-admin"
                        @change="search"
                    />
                    <label class="form-check-label" for="is-admin">Admin</label>
                </div>
            </div>
            <div class="col">
                <label for="name">Name</label>
                <input
                    id="name"
                    type="text"
                    class="form-control"
                    @input="search"
                    v-model.lazy="searchCriteria.name"
                />
            </div>
            <div class="col">
                <label for="email">Email</label>
                <input
                    id="email"
                    type="text"
                    class="form-control"
                    @input="search"
                    v-model.lazy="searchCriteria.email"
                />
            </div>
        </div>
    </form>
</template>

<script>
export default {
    emits: ["search-user"],
    data() {
        return {
            onInputDelayedSeconds: 0,
            startSearch: false,
            searchCriteria: {
                username: "",
                name: "",
                email: "",
                isAdmin: false,
            },
        };
    },

    methods: {
        search() {
            this.$emit("search-user", this.searchCriteria);
        },
    },
    mounted() {
        this.search();
    },
};
</script>

<style></style>
