<template>
    <h1>Status create</h1>
</template>

<script>
import { mapActions } from "vuex";
export default {
    methods: {
        ...mapActions(["setActiveNav"]),
    },
    mounted() {
        this.setActiveNav({
            nav: "admin-status-create",
        });
    },
};
</script>

<style></style>
