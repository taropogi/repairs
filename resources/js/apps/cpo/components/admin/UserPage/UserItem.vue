<template>
  <tr>
    <th scope="row">
      {{ user.username }}
    </th>
    <td>{{ user.name }}</td>
    <td>{{ user.email }}</td>
    <td>
      <p v-if="isAdmin" class="badge bg-primary me-1">Admin</p>
      <div v-else>
        <span
          v-for="(permission, index) in permissions"
          :key="permission"
          class="m-0 p-0"
        >
          {{ formatPermission(permission) }}
          <span v-if="index < permissions.length - 1"> | </span>
        </span>
      </div>
    </td>
    <td>
      <div class="btn-group btn-group-sm" role="group">
        <router-link class="btn btn-primary" :to="editUserLink">
          EDIT
        </router-link>

        <button type="button" class="btn btn-danger" @click="deleteUser">
          DELETE
        </button>
      </div>
    </td>
  </tr>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: ["user"],
  emits: ["delete-user"],
  computed: {
    ...mapGetters({
      allowedPermissions: "cpo/permissions",
    }),
    permissions() {
      if (this.user.is_admin) {
        return "Admin";
      }

      if (!this.user.permissions) {
        return [];
      }

      return this.user.permissions.filter((permission) =>
        this.allowedPermissions.some((allowed) => allowed.name === permission)
      );
    },
    isAdmin() {
      return this.user.is_admin ? "Yes" : "";
    },
    editUserLink() {
      return {
        name: "admin-user-edit",
        params: {
          id: this.user.id,
        },
      };
    },
  },
  methods: {
    deleteUser() {
      this.$emit("delete-user", this.user);
    },
    formatPermission(permission) {
      return permission
        .split("-")
        .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
        .join(" ");
    },
  },
};
</script>

<style></style>
