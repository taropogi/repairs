<template>
    <div class="modal" tabindex="-1" style="display: block">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">PDF History</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        @click="$emit('close')"
                    ></button>
                </div>
                <div class="modal-body">
                    <table class="table" v-if="pdfHistories">
                        <thead>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Filename</th>
                                <th scope="col">Created By</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="history in pdfHistories"
                                :key="history.id"
                            >
                                <th>
                                    {{ history.created_at }}
                                </th>
                                <td>
                                    {{ history.file_name }}
                                </td>
                                <td>
                                    {{ history.created_by }}
                                </td>
                                <td>
                                    <button class="btn btn-primary">
                                        Download
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                        @click="$emit('close')"
                    >
                        Close
                    </button>
                    <button type="button" class="btn btn-primary">
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            pdfHistories: null,
        };
    },
    props: ["id"],
    emits: ["close"],
    inject: ["setShowBackDrop"],
    methods: {
        async getPdfHistory() {
            await axios
                .get("api/cpo/pdf/history/" + this.id)
                .then((res) => {
                    this.pdfHistories = res.data;
                })
                .catch((err) => {
                    console.log("error: can't get pdf history");
                });
        },
    },
    mounted() {
        this.setShowBackDrop(true);
        this.getPdfHistory();
    },
    unmounted() {
        this.setShowBackDrop(false);
    },
};
</script>

<style></style>
