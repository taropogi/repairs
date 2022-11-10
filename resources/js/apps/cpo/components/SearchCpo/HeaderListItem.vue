<template>
    <tr :class="trClasses" v-if="!isDeleted">
        <th>
            <div class="form-check">
                <input
                    class="form-check-input"
                    type="checkbox"
                    :id="id"
                    v-model="isSelected"
                    @change="selectPo"
                />
            </div>
        </th>
        <th scope="row">{{ headerItem.id }}</th>
        <td>
            {{ headerItem.rpo_number }}
            <span class="badge bg-secondary" v-if="headerItem.locked"
                >Locked</span
            >
        </td>
        <td>
            {{ headerItem.customer_name }}
        </td>
        <td>{{ headerItem.customer_address }}</td>
        <td>{{ headerItem.contact_number }}</td>
        <td>{{ headerItem.prepared_by }}</td>
        <td>{{ headerItem.authorized_by }}</td>
        <td>{{ headerItem.status.status }}</td>
        <td>
            <div class="btn-group btn-group-sm" role="group">
                <button
                    v-if="!headerItem.locked"
                    type="button"
                    class="btn btn-danger"
                    @click="deleteCpo(headerItem)"
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
                    v-if="!headerItem.locked"
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
                }, 2000);
            }
        },
    },
    computed: {
        trClasses() {
            return {
                "table-warning": this.headerItem.locked,
                blink: this.isStatusUpdated,
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
            return "select-po-" + this.headerItem;
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
        selectPo() {
            if (this.isSelected) {
                this.$store.commit("cpo/addSelectedPo", {
                    id: this.headerItem.id,
                    row: this.headerItem,
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
                cpoId: this.headerItem.id,
            });
            if (res.data) {
                this.unselectPo();
                this.isDeleted = true;
                // this.$emit("delete-cpo");
            }
        },
        unselectPo() {
            this.$store.commit("cpo/removeSelectedPo", {
                id: this.headerItem.id,
            });
        },

        printCPOPdf() {
            window.location.href =
                "/repairs/generatePdf/?id=" + this.headerItem.id;
        },
        editCpoHeader() {
            this.$router.push({
                name: this.editHeaderLink,
                params: {
                    id: this.headerItem.id,
                },
            });
            // this.$emit("editCpo", cpoItemHeader);
        },
        isCurrentlySelected() {
            const selectedPos = this.$store.getters["cpo/getSelectedPos"];
            const selectedItem = selectedPos.find(
                (num) => num.id === this.headerItem.id
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
    animation: blink 1s linear;
}
@keyframes blink {
    0% {
        opacity: 0;
        transform: translateY(-30px);
    }
    50% {
        opacity: 0.5;
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
