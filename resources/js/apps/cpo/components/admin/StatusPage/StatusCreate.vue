<template>
  <div class="p-2">
    <h1 class="text-center bg-primary p-2 text-white">CREATE STATUS</h1>
    <form @submit="submitForm">
      <div class="mb-3">
        <label for="statusName" class="form-label">Status Name</label>
        <input
          type="text"
          class="form-control"
          required
          id="statusName"
          v-model="statusName"
        />
      </div>
      <div class="mb-3">
        <label for="statusDescription" class="form-label"
          >Status Description</label
        >
        <textarea
          class="form-control"
          id="statusDescription"
          v-model="statusDescription"
          rows="3"
        ></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</template>

<script>
export default {
  emits: ["status-created"],
  inject: ["showNotification"],
  data() {
    return {
      statusName: "",
      statusDescription: "",
      isSubmitting: false,
    };
  },
  methods: {
    async submitForm(e) {
      e.preventDefault();

      try {
        this.isSubmitting = true;
        // make the api call
        // then redirect to the status list page
        await axios.post("/api/status/create", {
          name: this.statusName,
          description: this.statusDescription,
        });

        this.showNotification({
          message: "Status created successfully",
          type: "success",
        });
        this.$emit("status-created");
      } catch (error) {
        console.error(error);
      } finally {
        this.statusName = "";
        this.statusDescription = "";
        this.isSubmitting = false;
      }
    },
  },
};
</script>

<style></style>
