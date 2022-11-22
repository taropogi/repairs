<template>
    <div class="modal fade show" tabindex="-1" style="display: block">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">
                        <strong>Status History</strong>
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        @click="$emit('close')"
                    ></button>
                </div>
                <div class="modal-body">
                    <status-history :headerId="headerId"></status-history>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        @click="$emit('close')"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import StatusHistory from "../StatusHistory/historyList.vue";
export default {
    inject: ["setShowBackDrop"],
    props: ["headerId"],
    emits: ["close"],
    components: {
        StatusHistory,
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
