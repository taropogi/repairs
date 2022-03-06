<template>
    <the-header></the-header>
    <router-view></router-view>
</template>

<script>
import TheHeader from "./TheHeader.vue";
export default {
    components: {
        TheHeader,
    },
    data() {
        return {};
    },
    mounted() {},
};
</script>

<style></style>
