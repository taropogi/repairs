<template>
  <div>
    <loading-overlay v-if="isUpdating" :text="'Updating, please wait . . '" />
    <div class="sticky-top bg-white">
      <h4 class="text-center bg-success text-white p-2">UPDATE CPO</h4>
    </div>

    <div class="p-2 border-top">
      <form-header
        @searched-header-row="setHeaderRow"
        :id="id"
        :key="formHeaderKey"
        @updating="isUpdating = true"
        @updated="isUpdating = false"
        :generated-rma="generatedRma"
      ></form-header>

      <header-lines
        class="mt-2"
        :header-id="+id"
        :header-row="headerRow"
        v-if="headerRow"
        :header-is-locked="!!headerRow.locked"
        @updating-lines="isUpdating = true"
        @updated-lines="updatedLines"
        @updated-rma="updatedRma"
      ></header-lines>
    </div>
  </div>
</template>

<script>
import headerLines from "./headerLines.vue";
import FormHeader from "./FormHeader.vue";
import LoadingOverlay from "../UI/LoadingOverlay.vue";
import { mapActions } from "vuex";

export default {
  components: {
    FormHeader,
    headerLines,
    LoadingOverlay,
  },
  inject: ["logPageVisit"],
  props: ["id"],

  data() {
    return {
      headerRow: null,
      isUpdating: false,
      isUpdatedAllLinesSuccess: false,
      formHeaderKey: 0,
      generatedRma: "",
    };
  },
  methods: {
    ...mapActions(["setActiveNav"]),
    updatedLines(headerRow) {
      if (headerRow.rma_number && !headerRow.is_rma_final) {
        // console.log("RMA Number: ", headerRow.rma_number);
        // this.formHeaderKey++;
      }
      this.isUpdating = false;
    },
    updatedRma(updatedHeaderRow) {
      this.headerRow = updatedHeaderRow;
      this.generatedRma = updatedHeaderRow.formatted_rma_number;
      // this.formHeaderKey++;
    },
    setHeaderRow(headerRow) {
      // console.log("headerRow", headerRow);
      this.headerRow = headerRow;
    },
  },
  beforeCreate() {
    this.$store.commit("setMainPageTitleHeader", "CPO - Edit");
    // this.$store.commit("setActiveNav", {
    //     nav: "edit-cpo",
    // });
  },
  mounted() {
    this.setActiveNav({
      nav: "edit-cpo",
    });
  },
  updated() {
    if (this.headerRow) {
      this.logPageVisit("Edit CPO: " + this.headerRow?.id);
    }
  },
};
</script>

<style scoped>
.updated-header-enter-from {
  opacity: 0;
  transform: translateY(-30px);
}

.updated-header-enter-active {
  transition: all 0.3s ease-out;
}
.updated-header-enter-to {
  opacity: 1;
  transform: translateY(0);
}

.updated-header-leave-from {
  opacity: 1;
  transform: translateY(0);
}

.updated-header-leave-active {
  transition: all 0.3s ease-in;
}
.updated-header-leave-to {
  opacity: 0;
  transform: translateY(-30px);
}
</style>
