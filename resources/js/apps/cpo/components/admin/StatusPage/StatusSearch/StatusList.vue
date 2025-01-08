<template>
  <div class="p-2">
    <h1 class="text-center bg-info p-2">STATUS LIST</h1>
    <table class="table table-sm table-hover table-striped">
      <thead>
        <tr class="table-primary">
          <th scope="col">ID/SEQUENCE</th>
          <th scope="col">STATUS</th>
          <th scope="col">DESCRIPTION</th>
          <th scope="col">ACTIONS</th>
        </tr>
      </thead>
      <tbody v-if="statuses">
        <status-item
          v-for="status in statuses"
          :key="status.id"
          :status="status"
          :is-editing-id="isEditingId"
          @status-deleted="
            () => {
              this.statuses = this.statuses.filter((s) => s.id !== status.id);
            }
          "
          @edit="
            (id) => {
              isEditingId = id;
            }
          "
          @status-updated="updatedStatus"
        />
      </tbody>
    </table>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import StatusItem from "./StatusItem.vue";
export default {
  components: {
    StatusItem,
  },
  data() {
    return {
      statuses: null,
      isEditingId: 0,
    };
  },
  methods: {
    ...mapActions(["setActiveNav"]),
    updatedStatus(updatedStatus) {
      this.isEditingId = 0;
      // update the local status
      this.statuses = this.statuses.map((status) => {
        if (status.id === updatedStatus.id) {
          return updatedStatus;
        }
        return status;
      });
    },
    async getStatuses() {
      try {
        const res = await axios.get("/api/statuses");
        this.statuses = res.data.statuses;
      } catch (error) {
        console.log(error.message);
      }
    },
  },
  mounted() {
    this.setActiveNav({
      nav: "admin-status-list",
    });

    this.getStatuses();
  },
};
</script>

<style></style>
