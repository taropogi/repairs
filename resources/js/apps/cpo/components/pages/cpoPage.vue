<template>
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
            <side-bar></side-bar>
        </div>
        <div class="col p-1">
            <router-view v-slot="slotProps">
                <transition name="router" mode="out-in">
                    <component :is="slotProps.Component"></component>
                </transition>
            </router-view>
        </div>
    </div>
</template>

<script>
export default {};
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
    transform: translateY(30px);
}
</style>
