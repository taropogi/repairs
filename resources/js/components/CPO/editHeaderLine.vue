<template>
    <tr>
        <th scope="row">{{ lineDetailsLocal.lineNumber }}</th>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.description"
                @input="changedLineValue"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.price"
                @input="changedLineValue"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.hcopy"
                @input="changedLineValue"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.qtyReturned"
                @input="changedLineValue"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.unit"
                @input="changedLineValue"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.qtyInspect"
                @input="changedLineValue"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.goodCondition"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.goodCondition"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.minorRepairClean"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.repairPartsNeeded"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.damaged"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.comments"
            />
        </td>
        <td>
            <input type="text" class="form-control form-control-sm" />
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
    props: ["lineNumber", "lineDetails", "lineIndex"],

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
