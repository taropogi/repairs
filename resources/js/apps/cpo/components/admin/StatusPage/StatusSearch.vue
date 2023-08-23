<template>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody v-if="statuses">
            <tr v-for="status in statuses" :key="status.id">
                <td>{{ status.status }}</td>
                <td>
                    <div
                        class="btn-group"
                        role="group"
                        aria-label="Basic outlined example"
                    >
                        <button type="button" class="btn btn-outline-primary">
                            Edit
                        </button>
                        <button type="button" class="btn btn-outline-danger">
                            Delete
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
import { mapActions } from "vuex";
export default {
    data() {
        return {
            statuses: null,
        };
    },
    methods: {
        ...mapActions(["setActiveNav"]),
        async getStatuses() {
            await axios
                .get("/api/statuses")
                .then((res) => {
                    this.statuses = res.data.statuses;
                })
                .catch((res) => {
                    // console.log(res);
                });
        },
    },
    mounted() {
        this.setActiveNav({
            nav: "admin-status-list",
        });

        this.getStatuses();
    },
};
</script>

<style></style>
