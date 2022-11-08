<template>
    <form>
        <div class="row">
            <div class="col">
                <label>Customer Name</label>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    @input="search"
                    v-model.lazy="searchCriteria.searchName"
                />
            </div>
            <div class="col">
                <label>Customer Address</label>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    @input="search"
                    v-model.lazy="searchCriteria.searchAddress"
                />
            </div>
            <div class="col">
                <label>Contact #</label>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    @input="search"
                    v-model.lazy="searchCriteria.searchContactNumber"
                />
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label>RPO #</label>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    @input="search"
                    v-model.lazy="searchCriteria.searchRpoNumber"
                />
            </div>
            <div class="col">
                <label>Prepared By</label>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    @input="search"
                    v-model.lazy="searchCriteria.searchPreparedBy"
                />
            </div>
            <div class="col">
                <label>Authorized By</label>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    @input="search"
                    v-model.lazy="searchCriteria.searchAuthorizedBy"
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
                searchName: "",
                searchAddress: "",
                searchContactNumber: "",
                searchRpoNumber: "",
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
