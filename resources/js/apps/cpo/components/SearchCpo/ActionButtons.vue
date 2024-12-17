<template>
  <div class="nowrap">
    <button
      type="button"
      class="btn tooltip-wrapper mx-1"
      :class="{
        'btn-danger': canDeleteCpo && !localHeaderItem.locked,
        'btn-secondary': !canDeleteCpo || localHeaderItem.locked,
      }"
      @click="deleteCpo"
      :disabled="!canDeleteCpo || localHeaderItem.locked"
    >
      <span class="nowrap fw-bold"> <i class="bi bi-trash"></i> DELETE </span>
    </button>

    <button
      type="button"
      class="btn btn-success tooltip-wrapper mx-1"
      @click="editCpoHeader"
    >
      <span v-if="!canEditCpo" class="nowrap fw-bold">
        <i class="bi bi-eye me-1"></i> VIEW
      </span>
      <span v-else class="nowrap fw-bold">
        <i class="bi bi-pencil-square me-1"></i> EDIT
      </span>
    </button>
    <button
      type="button"
      class="btn tooltip-wrapper mx-1"
      :class="{
        'btn-info': canDownloadCpoPdf && !localHeaderItem.locked,
        'btn-secondary': !canDownloadCpoPdf || localHeaderItem.locked,
      }"
      @click="printCPOPdf"
      :disabled="
        !canDownloadCpoPdf || localHeaderItem.locked || isDownloadingPdf
      "
    >
      <span class="nowrap fw-bold">
        <i
          v-if="isDownloadingPdf"
          class="spinner-border spinner-border-sm me-1"
        ></i>
        <i v-else class="bi bi-file-earmark-pdf text-sm"></i> PDF
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
  data() {
    return {
      isDownloadingPdf: false,
    };
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
      this.isDownloadingPdf = true;
      // console.log(this.localHeaderItem.id);
      // this.$emit("show-pdf-history", { id: this.localHeaderItem.id });

      // const pdfWindow = window.open("", "_blank");
      // pdfWindow.location.href =
      //   this.linkGeneratePdf + "/?id=" + this.localHeaderItem.id;
      window.location.href =
        this.linkGeneratePdf + "/?id=" + this.localHeaderItem.id;

      setTimeout(() => {
        this.isDownloadingPdf = false;
      }, 2000);

      // console.log(this.linkGeneratePdf + "/?id=" + this.localHeaderItem.id);
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
