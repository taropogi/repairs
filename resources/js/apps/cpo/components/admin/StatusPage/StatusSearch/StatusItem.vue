<template>
  <tr>
    <td>{{ status.id }}</td>
    <td
      style="width: 40%"
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
    <td
      style="width: 40%"
      :class="{
        'bg-primary': isEditing,
      }"
    >
      <div v-if="isEditing">
        <input
          type="text"
          class="form-control"
          v-model="localStatus.description"
        />
      </div>
      <span v-else>
        {{ status.description }}
      </span>
    </td>
    <td>
      <div class="nowrap" v-if="!isEditing && !deleteConfirming">
        <button
          type="button"
          class="btn btn-outline-primary mx-1"
          @click="editStatus"
        >
          <span class="nowrap">
            <i class="bi bi-pencil"></i>
            EDIT</span
          >
        </button>
        <button
          type="button"
          class="btn btn-outline-danger"
          @click="deleteConfirm"
        >
          <span class="nowrap">
            <i class="bi bi-trash"></i>
            DELETE
          </span>
        </button>
      </div>
      <div class="nowrap" v-else>
        <div v-if="deleteConfirming">
          <button type="button" class="btn btn-warning" @click="deleteStatus">
            <span class="nowrap">
              <i class="bi bi-exclamation-triangle"></i>
              CONFIRM DELETE
            </span>
          </button>
          <button
            type="button"
            class="btn btn-danger mx-1"
            @click="
              () => {
                deleteConfirming = false;
              }
            "
          >
            <span>
              <i class="bi bi-x-circle"></i>
              CANCEL
            </span>
          </button>
        </div>
        <div class="nowrap" v-if="isEditing">
          <button
            type="button"
            class="btn btn-primary"
            :disabled="isSaving"
            @click="saveStatus"
          >
            <span class="nowrap">
              <i class="bi bi-save"></i>
              SAVE
            </span>
          </button>
          <button
            type="button"
            class="btn btn-danger"
            :disabled="isSaving"
            @click="$emit('edit', 0)"
          >
            CANCEL
          </button>
        </div>
      </div>
    </td>
  </tr>
</template>

<script>
import { nextTick } from "vue";

export default {
  emits: ["edit", "status-updated", "status-deleted"],
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
      isDeleting: false,
      deleteConfirming: false,
    };
  },
  computed: {
    isEditing() {
      return this.isEditingId === this.status.id;
    },
  },
  methods: {
    deleteConfirm() {
      this.deleteConfirming = true;
    },
    async deleteStatus() {
      try {
        this.isDeleting = true;
        await axios.delete(`/api/status/delete/${this.status.id}`);
        this.$emit("status-deleted", this.status.id);
      } catch (error) {
        console.log(error.message);
      } finally {
        this.isDeleting = false;
      }
    },
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
