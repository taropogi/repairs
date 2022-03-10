<template>
    <form class="p-2">
        <h4 class="text-center bg-success p-2 text-white">
            Search CPO Headers
        </h4>
        <div class="row my-2">
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
                <input type="text" class="form-control" @input="search" />
            </div>
        </div>
        <div class="row my-2">
            <div class="col">
                <label>RPO #</label>
                <input type="text" class="form-control" @input="search" />
            </div>
            <div class="col">
                <label>Prepared By</label>
                <input type="text" class="form-control" @input="search" />
            </div>
            <div class="col">
                <label>Authorized By</label>
                <input type="text" class="form-control" @input="search" />
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
    mounted() {
        setInterval(() => {
            this.onInputDelayedSeconds++;
            // console.log(this.onInputDelayedSeconds);
        }, 1000);
    },
};
</script>

<style></style>
