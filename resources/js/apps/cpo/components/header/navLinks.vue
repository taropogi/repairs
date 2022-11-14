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
    <li class="nav-item">
        <router-link class="nav-link" :to="linkExportCpo"
            >Export CPO list</router-link
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
    data() {
        return {
            activeTab: "search",
        };
    },
    computed: {
        linkExportCpo() {
            return {
                name: "export-cpo-list",
            };
        },
    },
};
</script>

<style scoped>
/* .active {
    font-weight: bold;
    border-bottom: 1px solid #000;
    font-size: 12px;
    padding-bottom: 3px;
} */
</style>
