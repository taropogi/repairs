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

<style></style>
