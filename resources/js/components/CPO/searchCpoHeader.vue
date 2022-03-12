<template>
    <form class="p-2 border border-success">
        <h4 class="text-center bg-success p-1 mt-0 text-white">
            Search CPO Headersx
        </h4>
        <div class="row">
            <div class="col">
                <label>Customer Name</label>
                <input
                    type="text"
                    class="form-control"
                    @input="search"
                    v-model="searchCriteria.searchName"
                />
            </div>
            <div class="col">
                <label>Customer Address</label>
                <input
                    type="text"
                    class="form-control"
                    @input="search"
                    v-model="searchCriteria.searchAddress"
                />
            </div>
            <div class="col">
                <label>Contact #</label>
                <input
                    type="text"
                    class="form-control"
                    @input="search"
                    v-model="searchCriteria.searchContactNumber"
                />
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label>RPO #</label>
                <input
                    type="text"
                    class="form-control"
                    @input="search"
                    v-model="searchCriteria.searchRpoNumber"
                />
            </div>
            <div class="col">
                <label>Prepared By</label>
                <input
                    type="text"
                    class="form-control"
                    @input="search"
                    v-model="searchCriteria.searchPreparedBy"
                />
            </div>
            <div class="col">
                <label>Authorized By</label>
                <input
                    type="text"
                    class="form-control"
                    @input="search"
                    v-model="searchCriteria.searchAuthorizedBy"
                />
            </div>
        </div>
    </form>
</template>

<script>
export default {
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
    watch: {
        onInputDelayedSeconds(value) {
            if (value === 1) {
                if (this.startSearch) {
                    this.actualSearch();
                }
            }
        },
    },
    methods: {
        search() {
            if (!this.startSearch) {
                this.startSearch = true;
            }
            this.onInputDelayedSeconds = 0;
        },
        actualSearch() {
            this.$emit("search-cpo-header", this.searchCriteria);
        },
    },
    beforeCreate() {
        this.$store.commit("setMainPageTitleHeader", "CPO - Search");
    },
    mounted() {
        setInterval(() => {
            this.onInputDelayedSeconds++;
            // console.log(this.onInputDelayedSeconds);
        }, 1000);
    },
};
</script>

<style></style>
