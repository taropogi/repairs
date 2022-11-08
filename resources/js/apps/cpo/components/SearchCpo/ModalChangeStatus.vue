<template>
    <div class="modal fade show" tabindex="-1" style="display: block">
        <div class="modal-dialog modal-lg">
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
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th scope="col">CPO#</th>
                                <th scope="col">RPO #</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                            </tr>
                        </tbody>
                    </table>
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
    computed: {
        selectedPos() {
            return this.$store.getters["cpo/getSelectedPos"];
        },
    },
    methods: {
        closeModal() {
            console.log("close");
            this.$emit("close-modal");
        },
        saveChanges() {
            console.log("save");
            this.$emit("close-modal");
        },
    },
    mounted() {
        // console.log(this.selectedPos);
    },
};
</script>

<style scoped></style>
