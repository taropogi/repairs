<template>
    <form @submit.prevent="search" class="p-2">
        <h4 class="text-center bg-success p-2 text-white">
            Search CPO Headers
        </h4>
        <div class="row my-2">
            <div class="col">
                <label>Customer Name</label>
                <input type="text" class="form-control" />
            </div>
            <div class="col">
                <label>Customer Address</label>
                <input type="text" class="form-control" />
            </div>
            <div class="col">
                <label>Contact #</label>
                <input type="text" class="form-control" />
            </div>
        </div>
        <div class="row my-2">
            <div class="col">
                <label>RPO #</label>
                <input type="text" class="form-control" />
            </div>
            <div class="col">
                <label>Prepared By</label>
                <input type="text" class="form-control" />
            </div>
            <div class="col">
                <label>Authorized By</label>
                <input type="text" class="form-control" />
            </div>
        </div>

        <button type="submit" class="btn btn-success mt-2">Search</button>
    </form>
</template>

<script>
export default {
    methods: {
        search() {
            console.log("search");
        },
    },
};
</script>

<style></style>
