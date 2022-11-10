<template>
    <div class="modal fade show" tabindex="-1" style="display: block">
        <div class="modal-dialog modal-lg border border-primary">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title text-white">
                        <strong>Multiple RPO Change Status</strong>
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        @click="closeModal"
                    ></button>
                </div>
                <div class="modal-body">
                    <div v-if="selectedCpos">
                        Change status to:

                        <select class="form-select" v-model="selectedStatus">
                            <option
                                v-for="status in headerStatuses"
                                :key="status.id + status.status"
                                :value="status.id"
                            >
                                {{ status.status }}
                            </option>
                        </select>
                        <table
                            class="table table-sm mt-2 table-striped"
                            v-if="selectedCpos"
                        >
                            <thead>
                                <tr class="table-primary">
                                    <th scope="col">CPO#</th>
                                    <th scope="col">RPO #</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="cpo in selectedCpos" :key="cpo.id">
                                    <th scope="row">{{ cpo.id }}</th>
                                    <td>{{ cpo.rpo_number }}</td>
                                    <td>
                                        {{
                                            headerStatuses.find(
                                                (status) =>
                                                    status.id === cpo.status_id
                                            ).status
                                        }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        @click="closeModal"
                    >
                        Close
                    </button>
                    <button
                        type="button"
                        class="btn btn-primary"
                        @click="saveChanges"
                    >
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    emits: ["close-modal"],
    data() {
        return {
            selectedCpos: null,
            headerStatuses: null,
            selectedStatus: 1,
        };
    },
    computed: {
        selectedPosId() {
            return this.$store.getters["cpo/getSelectedPos"].map(
                (cpo) => cpo.id
            );
        },
    },
    methods: {
        closeModal() {
            console.log("close");
            this.$emit("close-modal");
        },
        async saveChanges() {
            const res = await axios.post(
                "/repairs/api/cpo/selected/update/status/",
                {
                    rpos: this.selectedPosId,
                    selected_status: this.selectedStatus,
                }
            );
            if (res.data) {
                // console.log(res.data);
                for (const cpo of res.data.updated_cpos) {
                    this.$store.commit("cpo/updateSelectedCpoStatus", {
                        id: cpo.id,
                        isStatusUpdated: true,
                    });
                }
            }
            this.$emit("close-modal");
        },

        async getSelectedPos() {
            const res = await axios.post("/repairs/api/cpo/selected", {
                rpos: this.selectedPosId,
            });
            if (res.data) {
                // console.log(res.data);
                this.selectedCpos = res.data.cpos;
                this.headerStatuses = res.data.header_statuses;
            }
        },
    },
    mounted() {
        this.getSelectedPos();
        // console.log(this.selectedCpos.length);
    },
};
</script>

<style scoped></style>
