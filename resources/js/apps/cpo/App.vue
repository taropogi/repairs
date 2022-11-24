<template>
    <div>
        <spinner-loading v-if="!oracleCustomers"></spinner-loading>
        <main
            :class="{ 'container-fluid': $route.name !== 'login-page' }"
            v-else
        >
            <div :class="{ backdrop: showBackDrop }"></div>

            <!-- <the-header></the-header>
        <side-bar></side-bar>

        <hr /> -->
            <router-view v-slot="slotProps">
                <transition name="app-router" mode="out-in">
                    <component :is="slotProps.Component"></component>
                </transition>
            </router-view>
        </main>
    </div>
</template>

<script>
import TheHeader from "./components/header/TheHeader.vue";
import SideBar from "./components/SideBar/SideBar.vue";
import { computed } from "vue";
import { mapGetters, mapActions } from "vuex";

export default {
    components: {
        TheHeader,
        SideBar,
    },
    data() {
        return { laravelData: null };
    },
    methods: {
        ...mapActions(["setShowBackDrop", "setOracleCustomers"]),
    },
    computed: {
        ...mapGetters(["showBackDrop", "oracleCustomers"]),
    },
    provide() {
        return {
            setShowBackDrop: this.setShowBackDrop,
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
        this.setOracleCustomers();
        // this.laravelData = window.laravelData;
        // console.log(this.laravelData);
        // console.log(this.$store.getters["auth/isLoggedIn"]);
        // console.log(this.$store.getters["auth/loggedUser"]);
    },
};
</script>

<style>
.backdrop {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 100%;
    background-color: rgba(0, 0, 0, 0.75);
    z-index: 10;
    opacity: 0.8;
}
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

label {
    font-weight: bold;
}
</style>
