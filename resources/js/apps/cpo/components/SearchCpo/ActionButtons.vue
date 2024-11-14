<template>
  <div class="btn-group btn-group-sm" role="group">
    <button
      v-if="!localHeaderItem.locked"
      type="button"
      class="btn"
      :class="{
        'btn-danger': canDeleteCpo,
        'btn-secondary': !canDeleteCpo,
      }"
      @click="deleteCpo"
      :disabled="!canDeleteCpo"
    >
      Delete
    </button>

    <button type="button" class="btn btn-success" @click="editCpoHeader">
      View{{ canEditCpo ? "/Edit" : "" }}
    </button>
    <button
      v-if="!localHeaderItem.locked"
      type="button"
      class="btn"
      :class="{
        'btn-info': canDownloadCpoPdf,
        'btn-secondary': !canDownloadCpoPdf,
      }"
      @click="printCPOPdf"
      :disabled="!canDownloadCpoPdf"
    >
      PDF
    </button>

    <button
      type="button"
      class="btn btn-lg btn-primary"
      v-if="localHeaderItem.locked"
      disabled
    >
      LOCKED
    </button>
  </div>
</template>

<script>
import { map } from "lodash";
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
