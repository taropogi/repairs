<template>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
            Users
        </a>
        <div class="dropdown-menu dropdown-menu-end">
            <router-link class="nav-link" :to="searchCpoPageLink"
                >Users</router-link
            >
        </div>
    </li>

    <li class="nav-item dropdown">
        <a
            class="nav-link dropdown-toggle"
            href="#"
            role="button"
            data-bs-toggle="dropdown"
        >
            CPO
        </a>
        <ul class="dropdown-menu">
            <li>
                <router-link class="dropdown-item" :to="searchCpoPageLink"
                    >Search CPO</router-link
                >
            </li>
            <li>
                <router-link class="dropdown-item" :to="encodeCpoPageLink"
                    >Encode CPO</router-link
                >
            </li>
        </ul>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
            {{ user.name }}
            <span class="badge rounded-pill bg-primary">ADMIN</span>
        </a>
        <ul class="dropdown-menu">
            <li>
                <a
                    href="#"
                    class="dropdown-item"
                    @click.prevent="$emit('log-out')"
                    >Logout</a
                >
            </li>
        </ul>
    </li>
</template>

<script>
export default {
    props: ["user"],
    emits: ["log-out"],
    computed: {
        searchCpoPageLink() {
            return {
                name: "admin-search-cpo",
            };
        },
        encodeCpoPageLink() {
            return {
                name: "admin-encode-cpo",
            };
        },
    },
};
</script>

<style></style>
