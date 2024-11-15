<template>
  <div class="p-2">
    <loading-overlay v-if="isUpdating" :text="'Updating, please wait . . '" />
    <form-header
      @searched-header-row="setHeaderRow"
      :id="id"
      @updating="isUpdating = true"
      @updated="isUpdating = false"
    ></form-header>
    <header-lines
      class="mt-2"
      v-if="headerRow"
      :header-id="id"
      :header-is-locked="headerRow.locked"
      @updating-lines="isUpdating = true"
      @updated-lines="isUpdating = false"
    ></header-lines>
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
