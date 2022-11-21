<template>
    <form class="sticky-top bg-secondary text-white p-5 m-0">
        <div class="row">
            <div class="col">
                <label>Username</label>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    @input="search"
                    v-model.lazy="searchCriteria.username"
                />
                <div class="form-check form-switch">
                    <input
                        v-model.lazy="searchCriteria.isAdmin"
                        class="form-check-input"
                        type="checkbox"
                        id="flexSwitchCheckDefault"
                    />
                    <label class="form-check-label" for="flexSwitchCheckDefault"
                        >Admin</label
                    >
                </div>
            </div>
            <div class="col">
                <label>Name</label>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    @input="search"
                    v-model.lazy="searchCriteria.name"
                />
            </div>
            <div class="col">
                <label>Email</label>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    @input="search"
                    v-model.lazy="searchCriteria.emailAddress"
                />
            </div>
        </div>
    </form>
</template>

<script>
export default {
    emits: ["search-cpo-header"],
    data() {
        return {
            onInputDelayedSeconds: 0,
            startSearch: false,
            searchCriteria: {
                username: "",
                name: "",
                emailAddress: "",
                isAdmin: false,
                searchPreparedBy: "",
                searchAuthorizedBy: "",
            },
        };
    },

    methods: {
        search() {
            this.$emit("search-cpo-header", this.searchCriteria);
        },
    },
    mounted() {
        this.search();
    },
};
</script>

<style></style>
