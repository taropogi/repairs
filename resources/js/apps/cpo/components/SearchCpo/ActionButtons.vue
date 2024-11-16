<template>
  <div class="btn-group btn-group-sm" role="group">
    <button
      type="button"
      class="btn"
      :class="{
        'btn-danger': canDeleteCpo,
        'btn-secondary': !canDeleteCpo,
      }"
      @click="deleteCpo"
      :disabled="!canDeleteCpo || localHeaderItem.locked"
    >
      <i class="bi bi-trash"></i>
    </button>

    <button type="button" class="btn btn-success" @click="editCpoHeader">
      <i class="bi bi-eye me-1" v-if="!canEditCpo"></i>
      <i class="bi bi-pencil-square me-1" v-else></i>
    </button>
    <button
      type="button"
      class="btn"
      :class="{
        'btn-info': canDownloadCpoPdf,
        'btn-secondary': !canDownloadCpoPdf,
      }"
      @click="printCPOPdf"
      :disabled="!canDownloadCpoPdf || localHeaderItem.locked"
    >
      <i class="bi bi-file-earmark-pdf"></i>
    </button>

    <!-- <button
      type="button"
      class="btn btn-lg btn-warning"
      v-if="localHeaderItem.locked"
      disabled
      title="Locked"
      ref="lockedButton"
    >
      <i class="bi bi-lock-fill"></i>
    </button> -->
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { Tooltip } from "bootstrap";
export default {
  emits: ["delete-cpo"],
  props: {
    localHeaderItem: {
      type: Object,
      required: true,
    },
  },

  computed: {
    ...mapGetters("auth", ["canDeleteCpo", "canEditCpo", "canDownloadCpoPdf"]),
    // hasPermissions() {
    //   return this.loggedUser.permissions ? true : false;
    // },
    laravelData() {
      return this.$store.getters.laravelData;
    },
    ...mapGetters("auth", ["loggedUser"]),
    editHeaderLink() {
      if (this.$store.getters["auth/loggedUser"].is_admin) {
        return "admin-edit-cpo";
      }

      return "edit-cpo";
    },
    linkGeneratePdf() {
      return this.laravelData.route_list.find(
        (route) => route.routeName === "generate-pdf"
      ).uri;
    },
  },
  methods: {
    deleteCpo() {
      this.$emit("delete-cpo", { id: this.localHeaderItem.id });
    },
    printCPOPdf() {
      // console.log(this.localHeaderItem.id);
      // this.$emit("show-pdf-history", { id: this.localHeaderItem.id });
      window.location.href =
        this.linkGeneratePdf + "/?id=" + this.localHeaderItem.id;
    },
    editCpoHeader() {
      this.$router.push({
        name: this.editHeaderLink,
        params: {
          id: this.localHeaderItem.id,
        },
      });
      // this.$emit("editCpo", cpoItemHeader);
    },
  },
  mounted() {
    // Initialize Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(this.$refs);
    tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new Tooltip(tooltipTriggerEl);
    });
  },
};
</script>
