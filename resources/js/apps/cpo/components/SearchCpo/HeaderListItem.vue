<template>
    <tr :class="trClasses" v-if="!isDeleted">
        <th>
            <div class="form-check">
                <input
                    v-if="!localHeaderItem.locked"
                    class="form-check-input"
                    type="checkbox"
                    :id="id"
                    v-model="isSelected"
                    @change="selectPo"
                />
                <label class="form-check-label" :for="id">
                    {{ localHeaderItem.id }}
                </label>
            </div>
        </th>

        <td>
            {{ headerItem.rpo_number }}
            <span class="badge bg-secondary" v-if="localHeaderItem.locked"
                >Locked</span
            >
        </td>
        <td>
            {{ localHeaderItem.customer_name }}
        </td>
        <td>{{ localHeaderItem.customer_address }}</td>
        <td>{{ localHeaderItem.contact_number }}</td>
        <td>{{ localHeaderItem.prepared_by }}</td>
        <td>{{ localHeaderItem.authorized_by }}</td>
        <td>{{ localHeaderItem.status.status }}</td>
        <td>
            <div class="btn-group btn-group-sm" role="group">
                <button
                    v-if="!localHeaderItem.locked"
                    type="button"
                    class="btn btn-danger"
                    @click="deleteCpo(localHeaderItem)"
                >
                    Delete <i class="bi bi-trash-fill"></i>
                </button>

                <button
                    type="button"
                    class="btn btn-success"
                    @click="editCpoHeader"
                >
                    Edit <i class="bi bi-pencil-fill"></i>
                </button>
                <button
                    v-if="!localHeaderItem.locked"
                    type="button"
                    class="btn btn-info"
                    @click="printCPOPdf"
                >
                    PDF <i class="bi bi-download"></i>
                </button>
            </div>
        </td>
    </tr>
</template>

<script>
export default {
    props: ["headerItem"],
    // emits: ["delete-cpo"],
    data() {
        return {
            localHeaderItem: this.headerItem,
            isSelected: false,
            isDeleted: false,
        };
    },
    watch: {
        isStatusUpdated(value) {
            if (value) {
                setTimeout(() => {
                    this.$store.dispatch("cpo/updateSelectedCpoStatus", {
                        id: this.headerItem.id,
                        isStatusUpdated: false,
                    });
                    this.getUpdatedHeader();
                }, 1000);
            }
        },
    },
    computed: {
        trClasses() {
            return {
                "table-warning": this.localHeaderItem.locked,
                blink: this.isStatusUpdated,
                "table-success": this.isStatusUpdated,
            };
        },
        selectedPos() {
            const selectedPos = this.$store.getters["cpo/getSelectedPos"];
            return selectedPos;
        },
        isStatusUpdated() {
            const selectedPos = this.$store.getters["cpo/getSelectedPos"];
            const selectedItem = selectedPos.find(
                (item) => item.id === this.headerItem.id
            );
            if (selectedItem) {
                return selectedItem.isStatusUpdated;
            }

            return null;
        },
        id() {
            return "select-po-" + this.localHeaderItem.id;
        },
        editHeaderLink() {
            if (this.$store.getters["auth/loggedUser"].is_admin) {
                return "admin-edit-cpo";
            }

            return "edit-cpo";
        },
        // isSelected() {
        //     return $store.getters["cpo/getSelectedPos"];
        // },
    },

    methods: {
        async getUpdatedHeader() {
            const res = await axios.get(
                "/repairs/api/cpo/" + this.localHeaderItem.id
            );
            if (res.data) {
                this.localHeaderItem = res.data.cpo;
                // console.log(res.data.cpo);
            }
        },
        selectPo() {
            if (this.isSelected) {
                this.$store.commit("cpo/addSelectedPo", {
                    id: this.localHeaderItem.id,
                    row: this.localHeaderItem,
                    isStatusUpdated: false,
                });
            } else {
                this.unselectPo();
            }

            // this.$store.commit("cpo/updateSelectedCpoStatus", {
            //     id: this.headerItem.id,

            //     isStatusUpdated: true,
            // });
        },
        async deleteCpo() {
            const res = await axios.post("/repairs/api/cpo/destroy", {
                cpoId: this.localHeaderItem.id,
            });
            if (res.data) {
                this.unselectPo();
                this.isDeleted = true;
                // this.$emit("delete-cpo");
            }
        },
        unselectPo() {
            this.$store.commit("cpo/removeSelectedPo", {
                id: this.localHeaderItem.id,
            });
        },

        printCPOPdf() {
            window.location.href =
                "/repairs/generatePdf/?id=" + this.localHeaderItem.id;
        },
        editCpoHeader() {
            this.$router.push({
                name: this.editHeaderLink,
                params: {
                    id: this.localHeaderItem.id,
                },
            });
            // this.$emit("editCpo", cpoItemHeader);
        },
        isCurrentlySelected() {
            const selectedPos = this.$store.getters["cpo/getSelectedPos"];
            const selectedItem = selectedPos.find(
                (num) => num.id === this.localHeaderItem.id
            );
            if (selectedItem) {
                this.isSelected = true;
            }
        },
    },
    mounted() {
        // console.log(this.isSelectedRow);
        this.isCurrentlySelected();
        // this.isSelected = true;
    },
};
</script>

<style scoped>
.blink {
    animation: blink 0.5s linear;
}
@keyframes blink {
    0% {
        opacity: 0;
        transform: translateX(-50px);
    }
    50% {
        opacity: 0.5;
    }
    100% {
        opacity: 1;

        transform: translateX(0);
    }
}
</style>
