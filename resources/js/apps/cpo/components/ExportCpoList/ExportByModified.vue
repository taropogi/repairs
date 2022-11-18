<template>
    <div>
        <h3 class="bg-success p-2 text-white rounded">Modified CPOs</h3>
        <span>Kindly specify a date range </span>
        <div class="my-3">
            <label for="date-modified-from" class="form-label">From </label>
            <input
                v-model="cpoModifiedDate.from"
                type="date"
                class="form-control"
                id="date-modified-from"
            />
        </div>

        <div class="mb-3">
            <label for="date-modified-to" class="form-label">To</label>
            <input
                v-model="cpoModifiedDate.to"
                type="date"
                class="form-control"
                id="date-modified-to"
            />
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            cpoModifiedDate: {
                from: new Date().toISOString().slice(0, 10),
                to: new Date().toISOString().slice(0, 10),
            },
        };
    },
    computed: {},
};
</script>

<style></style>
