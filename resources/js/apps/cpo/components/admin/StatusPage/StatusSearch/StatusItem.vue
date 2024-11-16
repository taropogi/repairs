<template>
  <tr>
    <td
      style="width: 80%"
      :class="{
        'bg-primary': isEditing,
      }"
    >
      <div v-if="isEditing">
        <input
          type="text"
          class="form-control"
          v-model="localStatus.status"
          ref="statusInput"
        />
      </div>
      <span v-else>
        {{ status.status }}
      </span>
    </td>
    <td>
      <div class="btn-group btn-group-sm" v-if="!isEditing">
        <button
          type="button"
          class="btn btn-outline-primary"
          @click="editStatus"
        >
          Edit
        </button>
        <button type="button" class="btn btn-outline-danger">Delete</button>
      </div>

      <div class="btn-group btn-group-sm" v-else>
        <button type="button" class="btn btn-primary" @click="saveStatus">
          Save
        </button>
        <button type="button" class="btn btn-danger" @click="$emit('edit', 0)">
          Cancel
        </button>
      </div>
    </td>
  </tr>
</template>

<script>
import { nextTick } from "vue";

export default {
  emits: ["edit", "status-updated"],
  props: {
    status: {
      type: Object,
      required: true,
    },
    isEditingId: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      localStatus: { ...this.status },
      isSaving: false,
    };
  },
  computed: {
    isEditing() {
      return this.isEditingId === this.status.id;
    },
  },
  methods: {
    editStatus() {
      this.$emit("edit", this.status.id);
      nextTick(() => {
        this.$refs.statusInput.focus();
      });
    },
    async saveStatus() {
      // console.log("test");
      try {
        this.isSaving = true;
        await axios.put(`/api/status/update`, this.localStatus);
        // this.$emit("edit", 0);
        this.$emit("status-updated", this.localStatus);
      } catch (error) {
        console.log(error.message);
      } finally {
        this.isSaving = false;
      }
    },
  },
};
</script>

<style></style>
