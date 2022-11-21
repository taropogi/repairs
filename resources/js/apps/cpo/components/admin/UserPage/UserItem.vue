<template>
    <tr>
        <th scope="row">
            {{ user.username }}
        </th>
        <td>{{ user.name }}</td>
        <td>{{ user.email }}</td>
        <td>{{ isAdmin }}</td>
        <td>
            <div class="btn-group btn-group-sm" role="group">
                <button type="button" class="btn btn-primary">EDIT</button>
                <button type="button" class="btn btn-danger">DELETE</button>
            </div>
        </td>
    </tr>
</template>

<script>
export default {
    props: ["user"],
    computed: {
        isAdmin() {
            return this.user.is_admin ? "Yes" : "";
        },
    },
};
</script>

<style></style>
