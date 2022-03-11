<template>
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
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in cpoHeaderList" :key="item.id">
                <th scope="row">{{ item.id }}</th>
                <td>{{ item.rpo_number }}</td>
                <td>{{ item.customer_name }}</td>
                <td>{{ item.customer_address }}</td>
                <td>{{ item.contact_number }}</td>
                <td>{{ item.prepared_by }}</td>
                <td>{{ item.authorized_by }}</td>
                <td>
                    <div
                        class="btn-group btn-group-sm"
                        role="group"
                        aria-label="Basic mixed styles example"
                    >
                        <button type="button" class="btn btn-danger">
                            Delete <i class="bi bi-trash-fill"></i>
                        </button>
                        <button type="button" class="btn btn-warning">
                            Add lines <i class="bi bi-file-plus-fill"></i>
                        </button>
                        <button type="button" class="btn btn-success">
                            Edit <i class="bi bi-pencil-fill"></i>
                        </button>
                        <button
                            type="button"
                            class="btn btn-info"
                            @click="printCPOPdf(item.id)"
                        >
                            Download Pdf <i class="bi bi-download"></i>
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    methods: {
        printCPOPdf(cpoId) {
            window.location.href = "/repairs/generatePdf/?id=" + cpoId;
        },
    },
    props: ["cpoHeaderList"],
};
</script>

<style></style>
