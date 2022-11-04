<template>
    <li class="nav-item">
        <router-link :to="loginPageLink" class="nav-link">Login</router-link>
    </li>

    <li class="nav-item">
        <router-link class="nav-link" :to="registerPageLink"
            >Register</router-link
        >
    </li>

    <a href="#" class="dropdown-item" @click.prevent="$emit('log-out')"
        >Logout</a
    >
</template>

<script>
export default {
    props: ["loginPageLink", "registerPageLink"],
    emits: ["log-out"],
};
</script>

<style></style>
