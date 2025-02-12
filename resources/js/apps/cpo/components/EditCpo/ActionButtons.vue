<template>
  <div>
    <teleport to="body">
      <modal-status-history
        v-if="showStatusHistory"
        @close="showStatusHistory = false"
        :header-id="cpoId"
      />
    </teleport>

    <button
      v-if="canEditCpoHeader"
      type="submit"
      class="btn mx-1"
      :class="{
        'btn-success': canEditCpo,
        'btn-secondary': !canEditCpo,
      }"
      @click="updateHeader"
      :disabled="!canEditCpo"
    >
      <span class="nowrap fw-bold">
        <i class="bi bi-pencil-square"></i>
        UPDATE HEADER
      </span>
    </button>

    <span
      class="btn btn-warning mx-1 nowrap fw-bold"
      @click="viewStatusHistory"
    >
      <i class="bi bi-clock-history"></i>
      VIEW STATUS HISTORY</span
    >

    <a
      v-if="canDownloadCpoPdf"
      href="#"
      class="btn mx-1"
      @click="printCPOPdf"
      :class="{
        disabled: !canDownloadCpoPdf,
        'btn-info': canDownloadCpoPdf,
        'btn-secondary': !canDownloadCpoPdf,
      }"
    >
      <span class="nowrap fw-bold">
        <i class="bi bi-file-earmark-pdf"></i>
        DOWNLOAD PDF
      </span>
    </a>
    <router-link
      :to="{ name: searchCpoLink }"
      class="btn btn-danger mx-1 fw-bold"
    >
      <i class="bi bi-x-circle"></i> CLOSE
    </router-link>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import ModalStatusHistory from "./ModalStatusHistory.vue";

export default {
  inject: ["laravelData", "logActivity"],
  emits: ["update-header"],
  props: {
    cpoId: {
      type: Number,
      required: true,
    },
  },
  components: {
    ModalStatusHistory,
  },
  data() {
    return {
      showStatusHistory: false,
    };
  },
  computed: {
    ...mapGetters("auth", [
      "canEditCpo",
      "canDownloadCpoPdf",
      "loggedUser",
      "canEditCpoHeader",
    ]),
    searchCpoLink() {
      if (this.loggedUser && this.loggedUser.is_admin) {
        return "admin-search-cpo";
      }
      return "search-cpo";
    },
    linkGeneratePdf() {
      return this.laravelData.route_list.find(
        (route) => route.routeName === "generate-pdf"
      ).uri;
    },
  },
  methods: {
    viewStatusHistory() {
      this.showStatusHistory = true;
      this.logActivity({
        action: "View CPO Status History",
        description: `CPO ID: ${this.cpoId}`,
      });
    },
    updateHeader() {
      // console.log("update header");
      this.logActivity({
        action: "Update CPO Header",
        description: `CPO ID: ${this.cpoId}`,
      });
      this.$emit("update-header");
    },
    printCPOPdf() {
      this.logActivity({
        action: "Download CPO PDF in Edit Page",
        description: `CPO ID: ${this.cpoId}`,
      });
      window.location.href = this.linkGeneratePdf + "/?id=" + this.cpoId;
    },
    gotoSearchPage() {
      this.$router.push({
        name: this.searchCpoLink,
      });
    },
  },
};
</script>

<style></style>
