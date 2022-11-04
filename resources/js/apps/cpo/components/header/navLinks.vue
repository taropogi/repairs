<template>
    <li class="nav-item">
        <router-link class="nav-link" :to="searchCpoPageLink"
            >Search CPO</router-link
        >
    </li>
    <li class="nav-item">
        <router-link class="nav-link" :to="encodeCpoPageLink"
            >Encode CPO</router-link
        >
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
            {{ user.name }}
        </a>
        <div class="dropdown-menu dropdown-menu-end">
            <a href="#" class="nav-link" @click.prevent="$emit('log-out')"
                >Logout</a
            >
        </div>
    </li>
</template>

<script>
export default {
    props: ["user", "searchCpoPageLink", "encodeCpoPageLink"],
    emits: ["log-out"],
};
</script>

<style></style>
