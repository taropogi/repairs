<template>
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">CPO#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">Contact#</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in cpoHeaderList" :key="item.id">
                    <th scope="row">{{ item.id }}</th>
                    <td>{{ item.customer_name }}</td>
                    <td>{{ item.customer_address }}</td>
                    <td>{{ item.contact_number }}</td>
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
