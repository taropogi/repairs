<template>
    <div>
        <user-search-from @search-user="searchUsers"></user-search-from>
        <user-list :search-criteria="searchCriteria"></user-list>
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
    data() {
        return {
            searchCriteria: {},
        };
    },
    methods: {
        ...mapActions(["setActiveNav"]),
        async searchUsers(searchCriteria) {
            this.searchCriteria = searchCriteria;
        },
    },
    mounted() {
        this.setActiveNav({
            nav: "admin-user-list",
        });
    },
};
</script>

<style></style>
