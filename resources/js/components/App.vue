<template>
    <the-header></the-header>
    <router-view v-slot="slotProps">
        <transition name="router" mode="out-in">
            <component :is="slotProps.Component"></component>
        </transition>
    </router-view>
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

<style>
.router-enter-from {
    opacity: 0;
    transform: translateY(-30px);
}
.router-enter-active {
    transition: all 0.3s ease-out;
}
.router-enter-to {
    opacity: 1;
    transform: translateY(0);
}
.router-leave-from {
    opacity: 1;
    transform: translateY(0);
}
.router-leave-active {
    transition: all 0.3s ease-out;
}
.router-leave-to {
    opacity: 0;
    transform: translateY(-30px);
}
</style>
