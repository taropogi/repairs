<template>
    <h1>Search User</h1>
</template>

<script>
import { mapActions } from "vuex";
export default {
    methods: {
        ...mapActions(["setActiveNav"]),
    },
    mounted() {
        this.setActiveNav({
            nav: "admin-user-list",
        });
    },
};
</script>

<style></style>
