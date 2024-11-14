<template>
  <div class="permissions-container p-3 border rounded bg-light">
    <h3 class="mb-3">Select Permissions</h3>
    <div
      class="form-check mb-2"
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
      <label class="form-check-label ms-2" :for="permission.name">
        {{ permission.description }}
      </label>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex/dist/vuex.cjs.js";

export default {
  emits: ["update:modelValue"],
  computed: {
    ...mapGetters("cpo", ["permissions"]),
  },
  props: {
    modelValue: {
      type: Array,
      default: () => [],
    },
  },

  data() {
    return {
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

<style scoped>
.permissions-container {
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 5px;
  background-color: #f9f9f9;
}

.permissions-container h3 {
  font-size: 1.25rem;
  font-weight: bold;
}

.form-check {
  display: flex;
  align-items: center;
}

.form-check-input {
  margin-right: 10px;
}

.form-check-label {
  font-size: 1rem;
}
</style>
