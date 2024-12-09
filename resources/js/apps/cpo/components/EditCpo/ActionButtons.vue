<template>
  <div class="text-center">
    <teleport to="body">
      <modal-status-history
        v-if="showStatusHistory"
        @close="showStatusHistory = false"
        :header-id="cpoId"
      />
    </teleport>

    <button
      type="submit"
      class="btn mx-1"
      :class="{
        'btn-success': canEditCpo,
        'btn-secondary': !canEditCpo,
      }"
      @click="$emit('update-header')"
      :disabled="!canEditCpo"
    >
      UPDATE HEADER
    </button>

    <span class="btn btn-warning mx-1" @click="showStatusHistory = true"
      >VIEW STATUS HISTORY</span
    >

    <a
      href="#"
      class="btn mx-1"
      @click="printCPOPdf"
      :class="{
        disabled: !canDownloadCpoPdf,
        'btn-info': canDownloadCpoPdf,
        'btn-secondary': !canDownloadCpoPdf,
      }"
      >DOWNLOAD PDF</a
    >

    <router-link :to="{ name: searchCpoLink }" class="btn btn-danger mx-1">
      <i class="bi bi-x-circle"></i> CLOSE
    </router-link>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import ModalStatusHistory from "./ModalStatusHistory.vue";

export default {
  inject: ["laravelData"],
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
