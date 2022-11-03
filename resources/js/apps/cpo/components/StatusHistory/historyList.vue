<template>
    <table class="table table-sm">
        <thead>
            <tr>
                <th scope="col">Date</th>
                <th scope="col">Status</th>
                <th scope="col">By</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="status in headerStatusHistory" :key="status.id">
                <th scope="row">
                    {{ status.created_at }}
                </th>
                <td>
                    {{
                        headerStatuses.find(
                            (stat) => stat.id == status.header_status_id
                        ).status
                    }}
                </td>
                <td>
                    {{
                        allUsers.find((user) => user.id == status.changed_by)
                            .name
                    }}
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    props: ["headerStatusHistory", "headerStatuses", "allUsers"],
};
</script>

<style></style>
