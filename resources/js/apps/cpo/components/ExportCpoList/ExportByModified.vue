<template>
    <div>
        <div class="mb-3">
            <label for="date-modified-from" class="form-label"
                >CPOs Modified From
            </label>
            <input
                v-model="cpoModifiedDate.from"
                type="date"
                class="form-control"
                id="date-modified-from"
            />
        </div>

        <div class="mb-3">
            <label for="date-modified-to" class="form-label"
                >CPOs Modified From</label
            >
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
