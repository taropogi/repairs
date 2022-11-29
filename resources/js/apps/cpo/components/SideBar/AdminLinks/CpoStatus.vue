<template>
    <ul class="nav nav-pills flex-column mb-auto my-2">
        <li class="nav-item">
            <router-link
                :to="adminSearchStatusLink"
                class="nav-link text-white"
                :class="{ active: isNavAdminStatusListActive }"
                >Status List
            </router-link>
        </li>
        <li>
            <router-link
                :to="adminCreateUserLink"
                class="nav-link text-white"
                :class="{ active: isNavAdminStatusCreateActive }"
                >Create New Status</router-link
            >
        </li>
    </ul>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    computed: {
        ...mapGetters(["activeNav"]),
        adminSearchStatusLink() {
            return {
                name: "admin-status-search",
            };
        },
        adminCreateUserLink() {
            return {
                name: "admin-status-create",
            };
        },
        isNavAdminStatusCreateActive() {
            if (this.activeNav?.nav === "admin-status-create") {
                return true;
            }
            return false;
        },
        isNavAdminStatusListActive() {
            if (this.activeNav?.nav === "admin-status-list") {
                return true;
            }
            return false;
        },
    },
};
</script>

<style></style>
