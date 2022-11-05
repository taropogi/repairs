<template>
    <div>
        <router-view v-slot="slotProps">
            <h1>ADMIN PAGE</h1>
            <transition name="router" mode="out-in">
                <component :is="slotProps.Component"></component>
            </transition>
        </router-view>
    </div>
</template>

<script>
export default {};
</script>

<style></style>
