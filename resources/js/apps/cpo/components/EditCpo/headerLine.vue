<template>
    <transition name="saved-line">
        <tr v-if="!lineUpdating">
            <th scope="row">{{ lineDetailsLocal.lineNumber }}</th>
            <td>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    :disabled="headerIsLocked"
                    v-model="lineDetailsLocal.description"
                />
            </td>
            <td>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    v-model="lineDetailsLocal.price"
                    :disabled="headerIsLocked"
                />
            </td>
            <td>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    v-model="lineDetailsLocal.hcopy"
                    :disabled="headerIsLocked"
                />
            </td>
            <td>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    v-model="lineDetailsLocal.qtyReturned"
                    :disabled="headerIsLocked"
                />
            </td>
            <td>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    v-model="lineDetailsLocal.unit"
                    :disabled="headerIsLocked"
                />
            </td>
            <td>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    v-model="lineDetailsLocal.qtyInspect"
                    :disabled="headerIsLocked"
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
                    <button
                        type="button"
                        class="btn btn-primary"
                        @click="saveLine"
                    >
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
    </transition>
</template>

<script>
export default {
    props: ["lineDetails", "headerIsLocked"],
    data() {
        return {
            lineDetailsLocal: this.lineDetails,
            lineUpdating: false,
        };
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
            //locally save
            this.lineUpdating = true;
            //  console.log(this.lineDetailsLocal);
            axios
                .post("/repairs/api/cpoline/update/", this.lineDetailsLocal)
                .then((res) => {
                    //   console.log(res);
                    // this.getCpoHeaderRow();
                    this.lineUpdating = false;
                })
                .catch((err) => {
                    console.log(err);
                });
            // this.$emit("saveLine", this.lineDetailsLocal);
        },
        deleteLine() {
            axios
                .post("/repairs/api/cpoline/destroy/", {
                    id: this.lineDetailsLocal.id,
                })
                .then((res) => {
                    this.$emit("deleteLine", this.lineDetailsLocal.id);
                    //console.log(res);
                    //  this.getCpoHeaderRow();
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
};
</script>

<style>
.saved-line-enter-from {
    opacity: 0;
    transform: translateY(-30px);
}

.saved-line-enter-active {
    transition: all 0.3s ease-out;
}
.saved-line-enter-to {
    opacity: 1;
    transform: translateY(0);
}

.saved-line-leave-from {
    opacity: 1;
    transform: translateY(0);
}

.saved-line-leave-active {
    transition: all 0.3s ease-in;
}
.saved-line-leave-to {
    opacity: 0;
    transform: translateY(-30px);
}
</style>
