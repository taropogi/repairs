<template>
  <table class="table table-sm table-hover">
    <thead>
      <tr class="table-primary">
        <th scope="col">Status</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody v-if="statuses">
      <status-item
        v-for="status in statuses"
        :key="status.id"
        :status="status"
      />
    </tbody>
  </table>
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
    };
  },
  methods: {
    ...mapActions(["setActiveNav"]),
    async getStatuses() {
      await axios
        .get("/api/statuses")
        .then((res) => {
          this.statuses = res.data.statuses;
        })
        .catch((res) => {
          // console.log(res);
        });
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
