<template>
    <div class="form-check my-3 form-switch">
        <input
            class="form-check-input"
            type="checkbox"
            :value="status.id"
            v-model="isSelected"
            @change="selectStatus"
            :id="status.id"
        />
        <label class="form-check-label" :for="status.id">
            {{ status.status }}
        </label>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
    props: ["status"],
    data() {
        return {
            isSelected: false,
        };
    },
    computed: {
        ...mapGetters("export", ["selectedStatus"]),
    },

    methods: {
        isCurrentlySelected() {
            const selectedItem = this.selectedStatus.find(
                (item) => item.id === this.status.id
            );
            if (selectedItem) {
                this.isSelected = true;
            }
        },
        selectStatus() {
            if (this.isSelected) {
                this.addSelectedStatus({
                    id: this.status.id,
                });
            } else {
                this.removeSelectedStatus({
                    id: this.status.id,
                });
            }
        },
        ...mapActions("export", ["addSelectedStatus", "removeSelectedStatus"]),
    },
    mounted() {
        this.isCurrentlySelected();
    },
};
</script>

<style></style>
