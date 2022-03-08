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
        return {
            isAuthenticated: false,
        };
    },
    mounted() {
        axios
            .get("/repairs/api/user")
            .then((response) => {
                this.$store.commit("setUser", response.data);
            })
            .catch((error) => {
                console.log("Ito ang error: " + error);
            });
    },
};
</script>

<style></style>
