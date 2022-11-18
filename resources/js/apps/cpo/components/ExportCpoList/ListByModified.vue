<template>
    <div class="overflow-auto" style="max-height: 1000px">
        <spinner-loading v-if="isSearching"></spinner-loading>
        <table class="table table-sm" v-else>
            <thead>
                <tr class="table-success">
                    <th scope="col">RPO #</th>
                    <th scope="col">Date Modified</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="cpo in cpos" :key="cpo.id">
                    <th scope="row">{{ cpo.rpo_number }}</th>
                    <td>
                        {{ cpo.updated_at.slice(0, 10) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            isSearching: false,
            cpos: null,
        };
    },
    watch: {
        cpoModifiedDate: {
            handler(newVal, oldVal) {
                this.getCpoByModified();
            },
            deep: true,
        },
    },
    computed: {
        ...mapGetters("export", ["cpoModifiedDate"]),
    },
    methods: {
        async getCpoByModified() {
            this.isSearching = true;
            const res = await axios.post("api/cpo/by/modified", {
                date_from: this.cpoModifiedDate.from,
                date_to: this.cpoModifiedDate.to,
            });
            if (res.data) {
                this.isSearching = false;
                this.cpos = res.data.cpos;
            }
        },
    },
    mounted() {
        this.getCpoByModified();
    },
};
</script>

<style></style>
