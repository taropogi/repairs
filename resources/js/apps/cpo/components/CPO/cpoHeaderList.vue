<template>
    <div class="my-2">
        <table class="table table-sm table-striped table-bordered">
            <thead class="table-success">
                <tr>
                    <th class="col">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                value=""
                            />
                        </div>
                    </th>
                    <th scope="col">CPO#</th>
                    <th scope="col">RPO #</th>
                    <th scope="col">Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">Contact#</th>
                    <th scope="col">Prepared By</th>
                    <th scope="col">Authorized By</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    :class="{ 'table-warning': item.locked }"
                    v-for="item in cpoHeaderList"
                    :key="item.id"
                >
                    <th>
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                v-model="selectedHeaders"
                            />
                        </div>
                    </th>
                    <th scope="row">{{ item.id }}</th>
                    <td>
                        {{ item.rpo_number }}
                        <span class="badge bg-secondary" v-if="item.locked"
                            >Locked</span
                        >
                    </td>
                    <td>
                        {{ item.customer_name }}
                    </td>
                    <td>{{ item.customer_address }}</td>
                    <td>{{ item.contact_number }}</td>
                    <td>{{ item.prepared_by }}</td>
                    <td>{{ item.authorized_by }}</td>
                    <td>{{ item.status.status }}</td>
                    <td>
                        <div
                            class="btn-group btn-group-sm"
                            role="group"
                            aria-label="Basic mixed styles example"
                        >
                            <button
                                v-if="!item.locked"
                                type="button"
                                class="btn btn-danger"
                                @click="deleteCpo(item)"
                            >
                                Delete <i class="bi bi-trash-fill"></i>
                            </button>

                            <button
                                type="button"
                                class="btn btn-success"
                                @click="editCpoHeader(item)"
                            >
                                Edit <i class="bi bi-pencil-fill"></i>
                            </button>
                            <button
                                v-if="!item.locked"
                                type="button"
                                class="btn btn-info"
                                @click="printCPOPdf(item.id)"
                            >
                                PDF <i class="bi bi-download"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <div
            class="btn-toolbar"
            role="toolbar"
            aria-label="Toolbar with button groups"
        >
            <div class="btn-group me-2" role="group" aria-label="First group">
                <button type="button" class="btn btn-primary">1</button>
                <button type="button" class="btn btn-primary">2</button>
                <button type="button" class="btn btn-primary">3</button>
                <button type="button" class="btn btn-primary">4</button>
            </div>
            <div class="btn-group" role="group" aria-label="Third group">
                <button type="button" class="btn btn-info">
                    Multi-select change Status
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            selectedHeaders: [],
        };
    },
    computed: {
        editHeaderLink() {
            if (this.$store.getters["auth/loggedUser"].is_admin) {
                return "admin-edit-cpo";
            }

            return "edit-cpo";
        },
    },
    methods: {
        deleteCpo(cpoItemHeader) {
            this.$emit("delete-cpo", cpoItemHeader);
        },
        editCpoHeader(cpoItemHeader) {
            // this.$store.dispatch("cpo/setEditingHeaderRow", {
            //     cpoId: cpoItemHeader.id,
            // });

            this.$router.replace({
                name: this.editHeaderLink,
                params: {
                    id: cpoItemHeader.id,
                },
            });
            // this.$emit("editCpo", cpoItemHeader);
        },
        printCPOPdf(cpoId) {
            window.location.href = "/repairs/generatePdf/?id=" + cpoId;
        },
    },
    props: ["cpoHeaderList"],
    updated() {
        //console.log(this.cpoHeaderList);
    },
};
</script>

<style></style>
