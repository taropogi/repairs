<template>
    <tr>
        <th scope="row">{{ lineDetailsLocal.lineNumber }}</th>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                :disabled="headerIsLocked"
                v-model="lineDetailsLocal.description"
                @input="changedLineValue"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.price"
                :disabled="headerIsLocked"
                @input="changedLineValue"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.hcopy"
                :disabled="headerIsLocked"
                @input="changedLineValue"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.qtyReturned"
                :disabled="headerIsLocked"
                @input="changedLineValue"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.unit"
                :disabled="headerIsLocked"
                @input="changedLineValue"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.qtyInspect"
                :disabled="headerIsLocked"
                @input="changedLineValue"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                :disabled="headerIsLocked"
                v-model="lineDetailsLocal.goodCondition"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                :disabled="headerIsLocked"
                v-model="lineDetailsLocal.goodCondition"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                :disabled="headerIsLocked"
                v-model="lineDetailsLocal.minorRepairClean"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                :disabled="headerIsLocked"
                v-model="lineDetailsLocal.repairPartsNeeded"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                :disabled="headerIsLocked"
                v-model="lineDetailsLocal.damaged"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                :disabled="headerIsLocked"
                v-model="lineDetailsLocal.comments"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                :disabled="headerIsLocked"
            />
        </td>
        <td>
            <div
                class="btn-group btn-group-sm"
                role="group"
                aria-label="Basic example"
            >
                <button type="button" class="btn btn-primary" @click="saveLine">
                    Save
                </button>
                <button
                    type="button"
                    class="btn btn-danger"
                    @click="deleteLine"
                >
                    Delete
                </button>
            </div>
        </td>
    </tr>
</template>

<script>
export default {
    props: ["lineNumber", "lineDetails", "lineIndex", "headerIsLocked"],

    data() {
        return {
            lineDetailsLocal: this.lineDetails,
        };
    },

    watch: {
        lineNumber(val) {
            this.lineDetailsLocal = this.lineDetails;
        },
    },

    computed: {
        isLocked() {
            return {
                disabled: this.headerIsLocked,
            };
        },
    },

    methods: {
        changedLineValue() {
            this.$emit("changedLineValue", {
                itemRow: this.lineDetailsLocal,
                lineIndex: this.lineIndex,
            });
        },
        saveLine() {
            this.$emit("saveLine", this.lineDetailsLocal);
        },
        deleteLine() {
            this.$emit("deleteLine", this.lineDetailsLocal.id);
        },
    },
};
</script>

<style></style>
