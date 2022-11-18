<template>
    <div>
        <h3 class="bg-success p-2 text-white rounded">Modified CPOs</h3>
        <span>Kindly specify a date range </span>
        <div class="my-3">
            <label for="date-modified-from" class="form-label">From </label>
            <input
                v-model="cpoModifiedDateLocal.from"
                type="date"
                class="form-control"
                id="date-modified-from"
                @change="setModifiedDate"
            />
        </div>

        <div class="mb-3">
            <label for="date-modified-to" class="form-label">To</label>
            <input
                v-model="cpoModifiedDateLocal.to"
                type="date"
                class="form-control"
                id="date-modified-to"
                @change="setModifiedDate"
            />
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
    data() {
        return {
            cpoModifiedDateLocal: {
                from: new Date().toISOString().slice(0, 10),
                to: new Date().toISOString().slice(0, 10),
            },
        };
    },
    computed: {
        ...mapGetters("export", ["cpoModifiedDate"]),
    },
    methods: {
        ...mapActions("export", ["setCpoModifiedDate"]),
        setModifiedDate() {
            this.setCpoModifiedDate({
                ...this.cpoModifiedDateLocal,
            });
        },
    },
};
</script>

<style></style>
