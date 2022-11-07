<template>
    <tr :class="{ 'table-warning': headerItem.locked }">
        <th>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" />
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
    emits: ["delete-cpo"],
    computed: {
        editHeaderLink() {
            if (this.$store.getters["auth/loggedUser"].is_admin) {
                return "admin-edit-cpo";
            }

            return "edit-cpo";
        },
    },
    methods: {
        async deleteCpo() {
            const res = await axios.post("/repairs/api/cpo/destroy", {
                cpoId: this.headerItem.id,
            });
            if (res.data) {
                this.$emit("delete-cpo");
            }
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
    },
};
</script>

<style></style>
