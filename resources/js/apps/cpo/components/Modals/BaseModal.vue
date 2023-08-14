<template>
    <div class="modal fade show" tabindex="-1" style="display: block">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <slot name="header"></slot>
                </div>
                <div class="modal-body">
                    <slot name="body"></slot>
                </div>
                <div class="modal-footer">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    inject: ["setShowBackDrop"],
    mounted() {
        this.setShowBackDrop(true);
    },
    unmounted() {
        this.setShowBackDrop(false);
    },
};
</script>

<style scoped>
.modal {
    z-index: 10001;
}
</style>
