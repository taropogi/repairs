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
        @updating="isUpdating = true"
        @updated="isUpdating = false"
      ></form-header>

      <header-lines
        class="mt-2"
        :header-id="+id"
        :header-row="headerRow"
        v-if="headerRow"
        :header-is-locked="!!headerRow.locked"
        @updating-lines="isUpdating = true"
        @updated-lines="isUpdating = false"
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
  props: ["id"],

  data() {
    return {
      headerRow: null,
      isUpdating: false,
      isUpdatedAllLinesSuccess: false,
    };
  },
  methods: {
    ...mapActions(["setActiveNav"]),
    updatedRma(updatedHeaderRow) {
      this.headerRow = updatedHeaderRow;
    },
    setHeaderRow(headerRow) {
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
