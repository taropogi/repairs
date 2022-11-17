<template>
    <div class="d-grid gap-2">
        <teleport to="body">
            <modal-change-status
                v-if="changeStatusMulti"
                @close-modal="closeModal"
            ></modal-change-status>
        </teleport>

        <button
            type="button"
            class="btn btn-info"
            @click="openModalChangeStatusMulti"
        >
            Multi-select options
        </button>
    </div>
</template>

<script>
import ModalChangeStatus from "../SearchCpo/ModalChangeStatus.vue";

export default {
    components: {
        ModalChangeStatus,
    },

    data() {
        return {
            changeStatusMulti: false,
        };
    },
    methods: {
        openModalChangeStatusMulti() {
            this.changeStatusMulti = true;
        },
        closeModal() {
            this.changeStatusMulti = false;
        },
    },
    mounted() {},
};
</script>

<style scoped></style>
