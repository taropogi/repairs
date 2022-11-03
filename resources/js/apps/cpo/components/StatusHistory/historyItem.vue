<template>
    <tr>
        <th scope="row">{{ dateCreated }}</th>
        <td>
            {{
                headerStatuses.find(
                    (stat) => stat.id == status.header_status_id
                ).status
            }}
        </td>
        <td>
            {{ allUsers.find((user) => user.id == status.changed_by).name }}
        </td>
    </tr>
</template>

<script>
export default {
    props: {
        status: {
            type: Object,
            required: true,
        },
        headerStatuses: {
            type: Array,
            required: true,
        },
        allUsers: {
            type: Array,
            required: true,
        },
    },
    computed: {
        dateCreated() {
            return new Date(this.status.created_at)
                .toISOString()
                .slice(0, 16)
                .replace("T", " ");
        },
    },
};
</script>

<style></style>
