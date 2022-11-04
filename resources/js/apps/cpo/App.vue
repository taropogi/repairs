<template>
    <div>
        <the-header></the-header>
        <hr />
        <router-view v-slot="slotProps">
            <transition name="app-router" mode="out-in">
                <component :is="slotProps.Component"></component>
            </transition>
        </router-view>
    </div>
</template>

<script>
import TheHeader from "./components/header/TheHeader.vue";
export default {
    components: {
        TheHeader,
    },
    mounted() {
        // console.log(this.$store.getters["auth/isLoggedIn"]);
    },
};
</script>

<style>
* {
    font-size: 12px;
}
.app-router-enter-from {
    opacity: 0;
    transform: translateY(-30px);
}
.app-router-enter-active {
    transition: all 0.3s ease-out;
}
.app-router-enter-to {
    opacity: 1;
    transform: translateY(0);
}
.app-router-leave-from {
    opacity: 1;
    transform: translateY(0);
}
.app-router-leave-active {
    transition: all 0.3s ease-out;
}
.app-router-leave-to {
    opacity: 0;
    transform: translateY(-30px);
}
</style>
