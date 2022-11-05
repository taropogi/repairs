<template>
    <div>
        <router-view v-slot="slotProps">
            <h1>CPO PAGE</h1>
            <transition name="router" mode="out-in">
                <component :is="slotProps.Component"></component>
            </transition>
        </router-view>
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
    transform: translateY(-30px);
}
</style>
