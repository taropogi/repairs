<template>
  <ul class="nav nav-pills flex-column mb-auto my-2">
    <li class="nav-item">
      <router-link
        :to="adminSearchUserLink"
        class="nav-link text-white"
        :class="{ active: isNavAdminUserListActive }"
      >
        <i class="bi bi-people me-2"></i> User List
      </router-link>
    </li>
    <li>
      <router-link
        :to="adminCreateUserLink"
        class="nav-link text-white"
        :class="{ active: isNavAdminUserCreateActive }"
      >
        <i class="bi bi-person-plus me-2"></i>
        Create New User</router-link
      >
    </li>
  </ul>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters(["activeNav"]),
    adminSearchUserLink() {
      return {
        name: "admin-user-search",
      };
    },
    adminCreateUserLink() {
      return {
        name: "admin-user-create",
      };
    },
    isNavAdminUserCreateActive() {
      if (this.activeNav && this.activeNav.nav === "admin-user-create") {
        return true;
      }
      return false;
    },
    isNavAdminUserListActive() {
      if (this.activeNav && this.activeNav.nav === "admin-user-list") {
        return true;
      }
      return false;
    },
  },
};
</script>

<style></style>
