<template>
  <div>
    <h3>Select Permissions</h3>
    <div
      class="form-check"
      v-for="permission in permissions"
      :key="permission.name"
    >
      <input
        class="form-check-input"
        type="checkbox"
        :id="permission.name"
        :value="permission.name"
        v-model="selectedPermissions"
      />
      <label class="form-check-label" :for="permission.name">{{
        permission.description
      }}</label>
    </div>
  </div>
</template>

<script>
export default {
  emits: ["update:modelValue"],
  props: {
    modelValue: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      permissions: [
        { description: "Create CPO", name: "create-cpo" },
        { description: "Edit CPO", name: "edit-cpo" },
        { description: "Delete CPO", name: "delete-cpo" },
        { description: "Create User", name: "create-user" },
        { description: "Edit User", name: "edit-user" },
        { description: "Delete User", name: "delete-user" },
      ],
      selectedPermissions: this.modelValue,
    };
  },
  watch: {
    selectedPermissions() {
      this.$emit("update:modelValue", this.selectedPermissions);
    },
    modelValue() {
      this.selectedPermissions = this.modelValue;
    },
  },
};
</script>

<style></style>
