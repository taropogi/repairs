<template>
    <transition name="saved-line">
        <tr v-if="showTr">
            <th scope="row">{{ lineDetails.line_number }}</th>
            <td>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    :disabled="headerIsLocked"
                    v-model="lineDetails.description"
                />
            </td>
            <td>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    v-model="lineDetails.price"
                    :disabled="headerIsLocked"
                />
            </td>
            <td>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    v-model="lineDetails.hcopy"
                    :disabled="headerIsLocked"
                />
            </td>
            <td>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    v-model="lineDetails.qty_returned"
                    :disabled="headerIsLocked"
                />
            </td>
            <td>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    v-model="lineDetails.unit"
                    :disabled="headerIsLocked"
                />
            </td>
            <td>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    v-model="lineDetails.qty_inspect"
                    :disabled="headerIsLocked"
                />
            </td>
            <td>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    :disabled="headerIsLocked"
                    v-model="lineDetails.good_condition"
                />
            </td>
            <td>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    :disabled="headerIsLocked"
                    v-model="lineDetails.good_condition"
                />
            </td>
            <td>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    :disabled="headerIsLocked"
                    v-model="lineDetails.minor_repair_clean"
                />
            </td>
            <td>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    :disabled="headerIsLocked"
                    v-model="lineDetails.repair_parts_needed"
                />
            </td>
            <td>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    :disabled="headerIsLocked"
                    v-model="lineDetails.damaged"
                />
            </td>
            <td>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    :disabled="headerIsLocked"
                    v-model="lineDetails.comments"
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
                <div class="btn-group btn-group-sm" role="group">
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
            lineUpdating: false,
            isDeleted: false,
        };
    },

    computed: {
        isLocked() {
            return {
                disabled: this.headerIsLocked,
            };
        },
        showTr() {
            return !this.lineUpdating;
        },
    },

    methods: {
        saveLine() {
            //locally save
            this.lineUpdating = true;
            //  console.log(this.lineDetailsLocal);
            axios
                .post("/repairs/api/cpoline/update/", this.lineDetails)
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
                    id: this.lineDetails.id,
                })
                .then((res) => {
                    //    this.isDeleted = true;
                    this.$emit("deleteLine", this.lineDetails.id);
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
