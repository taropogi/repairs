<template>
  <tr
    :class="{
      'bg-warning': isEditing,
    }"
  >
    <td style="width: 80%">
      <div v-if="isEditing">
        <input type="text" class="form-control" v-model="localStatus.status" />
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
          @click="isEditing = true"
        >
          Edit
        </button>
        <button type="button" class="btn btn-outline-danger">Delete</button>
      </div>

      <div class="btn-group btn-group-sm" v-else>
        <button type="button" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-danger" @click="isEditing = false">
          Cancel
        </button>
      </div>
    </td>
  </tr>
</template>

<script>
export default {
  props: {
    status: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      isEditing: false,
      localStatus: this.status,
      isSaving: false,
    };
  },
  methods: {
    async saveStatus() {
      this.isSaving = true;
      await axios
        .put(`/api/statuses/${this.localStatus.id}`, this.localStatus)
        .then((res) => {
          this.isEditing = false;
          this.isSaving = false;
        })
        .catch((res) => {
          this.isSaving = false;
        });
    },
  },
};
</script>

<style></style>
