<template>
    <div class="my-2">
        <table class="table table-sm table-striped table-bordered">
            <thead class="table-success">
                <tr>
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
    </div>
</template>

<script>
export default {
    methods: {
        deleteCpo(cpoItemHeader) {
            this.$emit("delete-cpo", cpoItemHeader);
        },
        editCpoHeader(cpoItemHeader) {
            // this.$store.dispatch("cpo/setEditingHeaderRow", {
            //     cpoId: cpoItemHeader.id,
            // });

            this.$router.replace({
                name: "edit-cpo",
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
