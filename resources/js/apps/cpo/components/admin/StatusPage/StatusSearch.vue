<template>
    <h1>Status Search</h1>
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
