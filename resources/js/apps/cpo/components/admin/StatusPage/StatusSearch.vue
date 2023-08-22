<template>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Test</td>
                <td>test</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
import { mapActions } from "vuex";
export default {
    methods: {
        ...mapActions(["setActiveNav"]),
    },
    mounted() {
        this.setActiveNav({
            nav: "admin-status-list",
        });
    },
};
</script>

<style></style>
