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
                <router-link class="btn btn-primary" :to="editUserLink">
                    EDIT
                </router-link>

                <button
                    type="button"
                    class="btn btn-danger"
                    @click="deleteUser"
                >
                    DELETE
                </button>
            </div>
        </td>
    </tr>
</template>

<script>
export default {
    props: ["user"],
    emits: ["delete-user"],
    computed: {
        isAdmin() {
            return this.user.is_admin ? "Yes" : "";
        },
        editUserLink() {
            return {
                name: "admin-user-edit",
                params: {
                    id: this.user.id,
                },
            };
        },
    },
    methods: {
        deleteUser() {
            this.$emit("delete-user", this.user);
        },
    },
};
</script>

<style></style>
