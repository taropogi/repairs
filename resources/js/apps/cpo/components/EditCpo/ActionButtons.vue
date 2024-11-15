<template>
  <div class="btn-group btn-group-sm g-3">
    <teleport to="body">
      <modal-status-history
        v-if="showStatusHistory"
        @close="showStatusHistory = false"
        :header-id="cpoId"
      />
    </teleport>
    <button
      type="submit"
      class="btn"
      :class="{
        'btn-success': canEditCpo,
        'btn-secondary': !canEditCpo,
      }"
      :disabled="!canEditCpo"
    >
      Update
    </button>

    <span class="btn btn-warning" @click="showStatusHistory = true"
      >Status History</span
    >

    <a
      href="#"
      class="btn"
      @click="printCPOPdf"
      :class="{
        disabled: !canDownloadCpoPdf,
        'btn-info': canDownloadCpoPdf,
        'btn-secondary': !canDownloadCpoPdf,
      }"
      >Download PDF</a
    >

    <router-link :to="{ name: searchCpoLink }" class="btn btn-danger"
      >Cancel</router-link
    >
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import ModalStatusHistory from "./ModalStatusHistory.vue";

export default {
  inject: ["laravelData"],
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
    ...mapGetters("auth", ["canEditCpo", "canDownloadCpoPdf", "loggedUser"]),
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
    printCPOPdf() {
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
