<template>
    <div class="modal fade show" tabindex="-1" style="display: block">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">
                        <strong>Are you sure to delete this CPO?</strong>
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        @click="$emit('close-modal-delete-cpo')"
                    ></button>
                </div>
                <div class="modal-body" v-if="headerRow">
                    <table class="table table-sm">
                        <thead>
                            <tr class="table-primary">
                                <th scope="col">CPO#</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">{{ headerRow.id }}</th>
                                <td>{{ headerRow.customer_name }}</td>
                                <td>{{ headerRow.status.status }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer" v-if="!isDeleting">
                    <button
                        type="button"
                        class="btn btn-danger"
                        @click="confirmDelete"
                    >
                        Yes
                    </button>
                    <button
                        type="button"
                        class="btn btn-primary"
                        @click="$emit('close-modal-delete-cpo')"
                    >
                        No
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["cpoId"],
    inject: ["setShowBackDrop"],
    data() {
        return {
            headerRow: null,
            isDeleting: false,
        };
    },
    methods: {
        async confirmDelete() {
            this.isDeleting = true;
            const res = await axios.post("api/cpo/destroy", {
                cpoId: this.cpoId,
            });
            if (res.data) {
                // this.unselectPo();
                // this.isDeleted = true;
                this.isDeleting = false;
                this.$emit("deleted-cpo");
            }
        },
        getCpoHeader() {
            axios
                .get("api/cpo/" + this.cpoId)
                .then((response) => {
                    this.headerRow = response.data.cpo;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    mounted() {
        this.getCpoHeader();
        this.setShowBackDrop(true);
    },
    unmounted() {
        this.setShowBackDrop(false);
    },
};
</script>

<style></style>
