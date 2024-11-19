<template>
  <div class="btn-group btn-group-sm">
    <button
      type="button"
      class="btn tooltip-wrapper"
      :class="{
        'btn-danger': canDeleteCpo && !localHeaderItem.locked,
        'btn-secondary': !canDeleteCpo || localHeaderItem.locked,
      }"
      @click="deleteCpo"
      :disabled="!canDeleteCpo || localHeaderItem.locked"
    >
      <span class="nowrap"> <i class="bi bi-trash"></i> Delete </span>
    </button>

    <button
      type="button"
      class="btn btn-success tooltip-wrapper"
      @click="editCpoHeader"
    >
      <span v-if="!canEditCpo" class="nowrap">
        <i class="bi bi-eye me-1"></i> View
      </span>
      <span v-else class="nowrap">
        <i class="bi bi-pencil-square me-1"></i> Edit
      </span>
    </button>
    <button
      type="button"
      class="btn tooltip-wrapper"
      :class="{
        'btn-info': canDownloadCpoPdf && !localHeaderItem.locked,
        'btn-secondary': !canDownloadCpoPdf || localHeaderItem.locked,
      }"
      @click="printCPOPdf"
      :disabled="!canDownloadCpoPdf || localHeaderItem.locked"
    >
      <span class="nowrap">
        <i class="bi bi-file-earmark-pdf text-sm"></i> PDF
      </span>
    </button>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
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
};
</script>
