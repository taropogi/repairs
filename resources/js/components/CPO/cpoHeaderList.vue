<template>
    <div>
        <table class="table table-sm table-striped table-bordered">
            <thead>
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
                                Delete
                            </button>
                            <button type="button" class="btn btn-warning">
                                Add lines
                            </button>
                            <button type="button" class="btn btn-success">
                                Edit
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
    props: ["cpoHeaderList"],
};
</script>

<style></style>
