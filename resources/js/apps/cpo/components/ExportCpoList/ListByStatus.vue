<template>
  <div class="overflow-auto" style="max-height: 1000px">
    <spinner-loading v-if="isSearching"></spinner-loading>
    <table class="table table-sm" v-else>
      <thead>
        <tr class="table-primary">
          <th scope="col">RPO #</th>
          <th scope="col">Status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="cpo in cpos" :key="cpo.id">
          <th scope="row">
            <router-link
              :to="{
                name: editHeaderLink,
                params: {
                  id: cpo.id,
                },
              }"
            >
              {{ cpo.formatted_id }}
            </router-link>
          </th>
          <td>{{ cpo.status.status }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  data() {
    return {
      cpos: null,
      isSearching: false,
    };
  },
  watch: {
    selectedStatus: {
      handler(newVal, oldVal) {
        this.getCpoByStatus();
      },
      deep: true,
    },
  },
  computed: {
    ...mapGetters("export", ["selectedStatus", "exportSearched"]),
    ...mapGetters("auth", ["loggedUser"]),
    editHeaderLink() {
      if (this.loggedUser?.is_admin) {
        return "admin-edit-cpo";
      }

      return "edit-cpo";
    },
  },
  methods: {
    async getCpoByStatus() {
      this.isSearching = true;
      const res = await axios.post("api/cpo/by/status", {
        status_ids: this.selectedStatus.map((el) => el.id),
      });
      if (res.data) {
        this.isSearching = false;
        this.cpos = res.data.cpos;

        this.setExportSearched({
          byStatus: this.cpos || [],
        });
      }
    },
    ...mapActions("export", ["setExportSearched"]),
  },
  mounted() {
    this.getCpoByStatus();
  },
};
</script>

<style></style>
