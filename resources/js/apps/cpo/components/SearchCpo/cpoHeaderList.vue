<template>
  <div class="p-2">
    <spinner-loading v-if="isSearching && !error"> </spinner-loading>
    <h1 v-else-if="error">
      {{ error }}
    </h1>
    <div class="my-2" v-else>
      <teleport to="body">
        <modal-delete-cpo
          v-if="deleteCpo"
          :cpo-id="deleteCpo.id"
          @close-modal-delete-cpo="closeModalDeleteCpo"
          @deleted-cpo="deleteCpoConfirm"
        ></modal-delete-cpo>
      </teleport>

      <teleport to="body">
        <modal-pdf-history
          v-if="showPdfHistoryId"
          :id="showPdfHistoryId"
          @close="showPdfHistoryId = null"
        ></modal-pdf-history>
      </teleport>

      <table class="table table-sm table-bordered table-striped table-hover">
        <thead
          class="table-success"
          style="position: sticky; top: 0; z-index: 1"
        >
          <tr>
            <th class="col tex-center">
              <span class="nowrap"
                >RPO#
                <span v-if="selectedPosCount > 0"
                  >[{{ selectedPosCount }}]</span
                ></span
              >
            </th>

            <th scope="col">DATE ENCODED</th>
            <th scope="col">NAME</th>
            <!-- <th scope="col">Address</th> -->
            <th scope="col">CONTACT#</th>
            <th scope="col">PREPARED BY</th>
            <th scope="col">AUTHORIZED BY</th>
            <th scope="col">STATUS</th>
            <th scope="col" style="width: 200px">ACTIONS</th>
          </tr>
        </thead>

        <transition-group tag="tbody" name="cpo-list">
          <header-list-item
            v-for="item in cpoHeaderList"
            :key="item.id"
            :header-item="item"
            @delete-cpo="openDeleteCpo"
            @show-pdf-history="
              (cpo) => {
                showPdfHistoryId = cpo.id;
              }
            "
          ></header-list-item>
        </transition-group>
      </table>
    </div>
  </div>
</template>

<script>
import HeaderListItem from "./HeaderListItem.vue";
import ModalPdfHistory from "../Modals/PdfHistory.vue";
import ModalDeleteCpo from "../DeleteCpo/ModalDeleteCpo.vue";
import { mapGetters } from "vuex";

export default {
  components: {
    HeaderListItem,
    ModalPdfHistory,
    ModalDeleteCpo,
  },
  data() {
    return {
      cpoHeaderList: [],
      selectedHeaders: [],
      isSearching: false,
      showPdfHistoryId: null,
      deleteCpo: null,
      error: null,
    };
  },

  props: ["searchCriteria"],
  inject: ["showNotification"],
  computed: {
    ...mapGetters("cpo", ["deletedCpos"]),
    cpoListCount() {
      return this.cpoHeaderList.length;
    },
    selectedPosCount() {
      return this.selectedPos.length;
    },
    selectedPos() {
      return this.$store.getters["cpo/getSelectedPos"];
    },
  },
  watch: {
    deletedCpos: {
      handler(newVal, oldVal) {
        for (const cpo of newVal) {
          // console.log("ok " + cpo);
          this.deleteCpoConfirm(cpo, "multiple");
        }
      },
      deep: true,
    },
    cpoListCount(value) {
      if (value <= 40) {
        // console.log("search");
        // this.getCpoHeaders();
      }
    },
    searchCriteria: {
      handler(newValue, oldValue) {
        // console.log(newValue, oldValue);

        this.getCpoHeaders();

        // Note: `newValue` will be equal to `oldValue` here
        // on nested mutations as long as the object itself
        // hasn't been replaced.
      },
      deep: true,
    },
  },

  methods: {
    openDeleteCpo(cpoId) {
      this.deleteCpo = cpoId;
    },
    deleteCpoConfirm(deleteCpo, type = "single") {
      // console.log(deleteCpo);
      const filteredList = this.cpoHeaderList.filter(
        (el) => el.id !== deleteCpo.id
      );
      this.cpoHeaderList = filteredList;
      this.closeModalDeleteCpo();
      if (type === "single") {
        this.showNotification({
          message: `CPO# ${deleteCpo.formatted_id} has been deleted`,
          type: "error",
        });
      }
    },
    closeModalDeleteCpo() {
      this.deleteCpo = null;
    },
    getCpoHeaders() {
      this.isSearching = true;
      this.error = null;
      axios
        .get("api/cpo", {
          params: {
            ...this.searchCriteria,
          },
        })
        .then((response) => {
          this.cpoHeaderList = response.data.cpos;
          this.isSearching = false;
        })
        .catch((error) => {
          this.error = error;
        });
    },
  },
  mounted() {
    // this.getCpoHeaders();
  },
  updated() {
    // console.log(this.searchCriteria);
  },
};
</script>

<style scoped>
.cpo-list-leave-from {
  opacity: 1;
  transform: translateX(0);
}
.cpo-list-leave-active {
  transition: all 1s ease-in;
  position: absolute;
}
.cpo-list-leave-to {
  opacity: 0;
  transform: translateX(30px);
}

.cpo-list-move {
  transition: transform 0.8s ease;
}

.fixed-header {
  position: sticky;
  top: 0;
  z-index: 1;
  background-color: white; /* Ensure the background color matches the table */
}
</style>
