<template>
    <div class="px-2 pb-5">
        <the-header></the-header>
        <hr />
        <router-view v-slot="slotProps" class="mt-3">
            <transition name="app-router" mode="out-in">
                <component :is="slotProps.Component"></component>
            </transition>
        </router-view>
    </div>
</template>

<script>
import TheHeader from "./components/header/TheHeader.vue";
import { computed } from "vue";

export default {
    components: {
        TheHeader,
    },
    data() {
        return { laravelData: null };
    },
    provide() {
        return {
            laravelData: computed(() => this.laravelData),
        };
    },
    created() {
        if (
            this.$store.getters["auth/isLoggedIn"] &&
            this.$store.getters["auth/loggedUser"].is_admin
        ) {
            this.$store.commit("cpo/setGenLinks", [
                {
                    "search-cpo": "admin-search-cpo",
                },
            ]);
        } else {
            this.$store.commit("cpo/setGenLinks", [
                {
                    "search-cpo": "search-cpo",
                },
            ]);
        }
    },
    mounted() {
        this.$store.commit("setLaravelData", window.laravelData); // laravel data from layouts.app.blade.php

        this.laravelData = window.laravelData;

        // this.laravelData = window.laravelData;
        // console.log(this.laravelData);
        // console.log(this.$store.getters["auth/isLoggedIn"]);
        // console.log(this.$store.getters["auth/loggedUser"]);
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
