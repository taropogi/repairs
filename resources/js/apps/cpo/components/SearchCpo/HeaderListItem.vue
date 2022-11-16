<template>
    <tr :class="trClasses" v-if="!isRemovedTr">
        <th>
            <teleport to="body" v-if="isDeleteCpo">
                <modal-delete-cpo
                    :cpo-id="headerItem.id"
                    @close-modal-delete-cpo="closeModalDeleteCpo"
                    @deleted-cpo="deleteRow"
                ></modal-delete-cpo
            ></teleport>
            <div class="form-check">
                <input
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

                <button
                    type="button"
                    class="btn btn-lg btn-primary"
                    v-if="localHeaderItem.locked"
                    disabled
                >
                    LOCKED
                </button>
            </div>
        </td>
    </tr>
</template>

<script>
import ModalDeleteCpo from "../DeleteCpo/ModalDeleteCpo.vue";
export default {
    props: ["headerItem"],

    components: {
        ModalDeleteCpo,
    },
    data() {
        return {
            localHeaderItem: this.headerItem,
            isSelected: false,
            isDeleted: false,
            isDeleteCpo: false,
            isRemovedTr: false,
        };
    },
    watch: {
        isSelectedDeleted(value) {
            if (value) {
                this.deleteRow();
            }
        },
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
        laravelData() {
            return this.$store.getters.laravelData;
        },
        linkGeneratePdf() {
            return this.laravelData.route_list.find(
                (route) => route.routeName === "generate-pdf"
            ).uri;
        },
        trClasses() {
            return {
                // "table-secondary": this.localHeaderItem.locked,
                blink: this.isStatusUpdated && !this.isDeleted,
                "table-success": this.isStatusUpdated && !this.isDeleted,
                "table-danger": this.isDeleted,
                "tr-exit": this.isDeleted,
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

        isSelectedDeleted() {
            const selectedPos = this.$store.getters["cpo/getSelectedPos"];
            const selectedItem = selectedPos.find(
                (item) => item.id === this.headerItem.id
            );
            if (selectedItem) {
                return selectedItem.isDeleted;
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
        deleteRow() {
            this.isDeleted = true;
            setTimeout(() => {
                this.unselectPo();
                this.isRemovedTr = true;
            }, 1000);
        },
        closeModalDeleteCpo() {
            this.isDeleteCpo = false;
        },
        async getUpdatedHeader() {
            const res = await axios.get("api/cpo/" + this.localHeaderItem.id);
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
                    isDeleted: false,
                });
            } else {
                this.unselectPo();
            }

            // this.$store.commit("cpo/updateSelectedCpoStatus", {
            //     id: this.headerItem.id,

            //     isStatusUpdated: true,
            // });
        },
        deleteCpo() {
            this.isDeleteCpo = true;
            // this.$emit("open-delete-cpo", this.localHeaderItem.id);
            // // open modal
            // const res = await axios.post("/repairs/api/cpo/destroy", {
            //     cpoId: this.localHeaderItem.id,
            // });
            // if (res.data) {
            //     this.unselectPo();
            //     this.isDeleted = true;
            //     // this.$emit("delete-cpo");
            // }
        },
        unselectPo() {
            this.$store.commit("cpo/removeSelectedPo", {
                id: this.localHeaderItem.id,
            });
        },

        printCPOPdf() {
            window.location.href =
                this.linkGeneratePdf + "/?id=" + this.localHeaderItem.id;

            // window.location.href =
            //     this.linkGeneratePdf + "/?id=" + this.localHeaderItem.id;
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
.tr-exit {
    animation: trExit 0.5s forwards;
}
@keyframes trExit {
    0% {
        opacity: 1;

        transform: translateX(0);
    }
    50% {
        opacity: 0.5;
    }
    100% {
        opacity: 0;
        transform: translateX(-50px);
    }
}

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
