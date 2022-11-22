<template>
    <div class="modal" tabindex="-1" style="display: block">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Delete User</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        @click="closeModal"
                    ></button>
                </div>
                <div class="modal-body">Delete {{ user.username }}</div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                        @click="closeModal"
                    >
                        Close
                    </button>
                    <button
                        type="button"
                        class="btn btn-primary"
                        @click="deleteUser"
                    >
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["user"],
    emits: ["close", "deleted-user"],
    inject: ["setShowBackDrop"],
    methods: {
        closeModal() {
            this.$emit("close");
        },
        async deleteUser() {
            await axios
                .post("api/users/delete/" + this.user.id)
                .then((response) => {
                    this.$emit("deleted-user");
                });
        },
    },
    mounted() {
        this.setShowBackDrop(true);
    },
    unmounted() {
        this.setShowBackDrop(false);
    },
};
</script>

<style></style>
