<template>
    <the-header></the-header>
    <router-view class="pt-2"></router-view>
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
