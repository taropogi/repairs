<template>
  <div>
    <spinner-loading v-if="isSearching"></spinner-loading>
    <table class="table table-sm" v-else>
      <thead>
        <tr class="table-danger">
          <th scope="col">RPO #</th>
          <th scope="col">Date</th>
          <th scope="col">Status From</th>
          <th scope="col">Status To</th>
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
          <td>
            {{ cpo.changed_date }}
          </td>
          <td>
            {{ cpo.status_old }}
          </td>
          <td>
            {{ cpo.status_new }}
          </td>
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
      isSearching: false,
      cpos: null,
    };
  },
  watch: {
    cpoChangedStatusDate: {
      handler(newVal, oldval) {
        this.getCpoChangedStatus();
      },
      deep: true,
    },
    cpoChangedStatusTo() {
      this.getCpoChangedStatus();
    },
    cpoChangedStatusCurrent() {
      this.getCpoChangedStatus();
    },
  },
  computed: {
    ...mapGetters("export", [
      "cpoChangedStatusDate",
      "cpoChangedStatusTo",
      "cpoChangedStatusCurrent",
    ]),
    ...mapGetters("auth", ["loggedUser"]),
    editHeaderLink() {
      if (this.loggedUser && this.loggedUser.is_admin) {
        return "admin-edit-cpo";
      }

      return "edit-cpo";
    },
  },
  methods: {
    async getCpoChangedStatus() {
      // console.log(this.cpoChangedStatusCurrent);
      this.isSearching = true;
      const res = await axios.post("api/cpo/changed/status", {
        date_from: this.cpoChangedStatusDate.from,
        date_to: this.cpoChangedStatusDate.to,
        status_to: this.cpoChangedStatusTo,
        only_current_status: this.cpoChangedStatusCurrent,
      });
      if (res.data) {
        this.isSearching = false;
        this.cpos = res.data.cpos;
        // console.log(res.data);
        this.setExportSearched({
          byChangedStatus: this.cpos || [],
        });
      }
    },
    ...mapActions("export", ["setExportSearched"]),
  },
  mounted() {
    this.getCpoChangedStatus();
  },
};
</script>

<style></style>
