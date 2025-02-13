<template>
  <base-modal>
    <template #header>
      <h5 class="modal-title text-white">
        <strong>Multiple RPO Change Status</strong>
      </h5>
      <button type="button" class="btn-close" @click="closeModal"></button>
    </template>
    <template #body>
      <div v-if="showConfirmDelete" class="text-center p-5">
        <p>
          You are about to delete the {{ selectedPosCount }} records. This
          action cannot be undone.
        </p>
        <p>Are you sure you want to proceed?</p>
      </div>
      <div v-if="selectedCpos && !showConfirmDelete">
        Change status to:

        <select
          class="form-select"
          v-model="selectedStatus"
          :disabled="!canEditCpo"
        >
          <option
            v-for="status in headerStatuses"
            :key="status.id + status.status"
            :value="status.id"
          >
            {{ status.status }}
          </option>
        </select>
        <table class="table table-sm mt-2 table-striped" v-if="selectedCpos">
          <thead>
            <tr class="table-primary">
              <th scope="col">RPO #</th>
              <th scope="col">Status</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="cpo in selectedCpos" :key="cpo.id">
              <th scope="row">{{ cpo.formatted_id }}</th>
              <td>
                {{
                  headerStatuses.find((status) => status.id === cpo.status_id)
                    .status
                }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </template>
    <template #default>
      <div v-if="showConfirmDelete">
        <button
          type="button"
          class="btn btn-danger m-2"
          @click="confirmDeleteYes"
        >
          Yes
        </button>
        <button
          type="button"
          class="btn btn-primary m-2"
          @click="cancelDeleteConfirm"
        >
          No
        </button>
      </div>
      <div v-else>
        <!-- <button
                            type="button"
                            class="btn btn-secondary m-2"
                            @click="closeModal"
                        >
                            Close
                        </button> -->

        <button
          type="button"
          class="btn m-2"
          @click="downloadPdfs"
          :disabled="!canDownloadCpoPdf"
          :class="{
            'btn-warning': canDownloadCpoPdf,
            'btn-secondary': !canDownloadCpoPdf,
          }"
        >
          Download PDFs
        </button>
        <button
          type="button"
          class="btn m-2"
          @click="saveChanges"
          :disabled="!canEditCpo"
          :class="{
            'btn-primary': canEditCpo,
            'btn-secondary': !canEditCpo,
          }"
        >
          Save changes
        </button>
        <button
          type="button"
          class="btn m-2"
          :class="{
            'btn-danger': canDeleteCpo,
            'btn-secondary': !canDeleteCpo,
          }"
          @click="confirmDelete"
          :disabled="!canDeleteCpo"
        >
          Delete
        </button>
      </div>
    </template>
  </base-modal>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
  emits: ["close-modal"],
  inject: ["laravelData", "showNotification"],
  data() {
    return {
      selectedCpos: null,
      headerStatuses: null,
      selectedStatus: 1,
      showConfirmDelete: false,
      deletedCpos: null,
    };
  },
  computed: {
    ...mapGetters("cpo", ["getSelectedPos"]),
    ...mapGetters("auth", ["canDeleteCpo", "canDownloadCpoPdf", "canEditCpo"]),
    selectedPosCount() {
      return this.getSelectedPos.length;
    },
    selectedPosId() {
      return this.getSelectedPos.map((cpo) => cpo.id);
    },
    linkGeneratePdfs() {
      return this.laravelData.route_list.find(
        (route) => route.routeName === "generate-pdfs"
      ).uri;
    },
  },
  methods: {
    ...mapActions("cpo", [
      "addDeletedCpos",
      "updateSelectedCpoDeleted",
      "resetSelectedCpos",
    ]),

    downloadPdfs() {
      // console.log("pdfs");
      window.location.href =
        this.linkGeneratePdfs + "/?id=" + this.selectedPosId;
    },
    cancelDeleteConfirm() {
      this.showConfirmDelete = false;
    },
    async confirmDeleteYes() {
      const res = await axios.post("api/cpo/destroy/multi", {
        selectedCpos: this.selectedPosId,
      });

      if (res.data) {
        this.deletedCpos = res.data.cpos_deleted;
        for (const cpo of this.deletedCpos) {
          this.updateSelectedCpoDeleted({
            id: cpo.id,
            isDeleted: true,
          });

          this.addDeletedCpos({
            id: cpo.id,
            formatted_id: cpo.formatted_id,
          });
        }
      }

      this.$emit("close-modal");
      this.showNotification({
        message: `${this.deletedCpos.length} CPOs has been deleted`,
        type: "error",
      });
    },
    confirmDelete() {
      this.showConfirmDelete = true;
    },
    closeModal() {
      this.$emit("close-modal");
    },
    async saveChanges() {
      const res = await axios.post("api/cpo/selected/update/status/", {
        rpos: this.selectedPosId,
        selected_status: this.selectedStatus,
      });
      if (res.data) {
        // console.log(res.data);
        for (const cpo of res.data.updated_cpos) {
          this.$store.commit("cpo/updateSelectedCpoStatus", {
            id: cpo.id,
            isStatusUpdated: true,
          });
        }
        setTimeout(() => {
          this.resetSelectedCpos();
        }, 2000);
      }
      this.$emit("close-modal");
    },

    async loadSelectedPos() {
      const res = await axios.post("api/cpo/selected", {
        rpos: this.selectedPosId,
      });
      if (res.data) {
        // console.log(res.data);
        this.selectedCpos = res.data.cpos;
        this.headerStatuses = res.data.header_statuses;
      }
    },
  },
  mounted() {
    this.loadSelectedPos();
  },
};
</script>
 