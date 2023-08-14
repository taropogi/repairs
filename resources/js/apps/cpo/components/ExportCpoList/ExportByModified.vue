<template>
    <div>
        <h3 class="bg-info p-2 text-white rounded">
            Modified CPOs
            <span v-if="searchedCount">({{ searchedCount }})</span>
        </h3>
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
                from:
                    new Date().getFullYear() +
                    "-" +
                    (Number(new Date().getMonth()) + 1) +
                    "-" +
                    new Date().getDate(),
                to:
                    new Date().getFullYear() +
                    "-" +
                    (Number(new Date().getMonth()) + 1) +
                    "-" +
                    new Date().getDate(),
            },
        };
    },
    computed: {
        ...mapGetters("export", ["cpoModifiedDate", "exportSearched"]),
        searchedCount() {
            return this.exportSearched.byModified.length;
        },
    },
    methods: {
        ...mapActions("export", ["setCpoModifiedDate"]),
        setModifiedDate() {
            this.setCpoModifiedDate({
                ...this.cpoModifiedDateLocal,
            });
        },
    },
    mounted() {
        this.setModifiedDate();
    },
};
</script>

<style></style>
