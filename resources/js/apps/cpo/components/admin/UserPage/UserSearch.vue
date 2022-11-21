<template>
    <div>
        <user-search-from></user-search-from>
        <user-list></user-list>
    </div>
</template>

<script>
import UserList from "./UserList.vue";
import UserSearchFrom from "./UserSearchForm.vue";
import { mapActions } from "vuex";
export default {
    components: {
        UserList,
        UserSearchFrom,
    },
    methods: {
        ...mapActions(["setActiveNav"]),
    },
    mounted() {
        this.setActiveNav({
            nav: "admin-user-list",
        });
    },
};
</script>

<style></style>
