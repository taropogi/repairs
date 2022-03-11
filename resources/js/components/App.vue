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
    beforeCreate() {
        //  console.log("try login");
        axios
            .get("/repairs/api/user")
            .then((response) => {
                this.$store.commit("auth/setIsLoggedIn", true);
                this.$store.commit("auth/setUser", response.data);

                //  console.log(response.data);
            })
            .catch((error) => {
                console.log("Ito ang error: " + error);
                axios.post("/repairs/api/logout").then((response) => {
                    //console.log(response);
                    this.$store.commit("auth/setIsLoggedIn", false);
                    this.$store.commit("auth/setUser", null);
                });
            });
    },
};
</script>

<style></style>
