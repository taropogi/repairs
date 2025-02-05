<template>
  <tr
    class="align-middle"
    :class="trClasses"
    :title="
      localHeaderItem.is_completed
        ? `${localHeaderItem.formatted_id} is already completed. Can no longer update.`
        : ''
    "
  >
    <th>
      <div class="form-check">
        <input
          class="form-check-input"
          type="checkbox"
          :id="id"
          v-model="isSelected"
          @change="selectPo"
        />
        <label class="form-check-label" :for="id">
          <span class="nowrap"
            >{{ localHeaderItem.formatted_id }}
            <i
              class="bi bi-lock-fill"
              v-if="localHeaderItem.is_completed"
              :class="{
                'text-warning': localHeaderItem.is_completed,
                'mx-2': localHeaderItem.is_completed,
              }"
            ></i
          ></span>
        </label>
      </div>
    </th>
    <td>
      <label class="form-check-label" :for="id">
        {{ localHeaderItem.formatted_rma_number }}
      </label>
    </td>
    <td>
      <label class="form-check-label" :for="id">
        <span v-if="!isToday">
          {{ formattedDate }}
        </span>
        <span v-else>
          <span class="badge bg-success">
            <small>TODAY</small>
          </span>
          |
          {{ formatDateTimeOnly }}
        </span>
      </label>
    </td>
    <td>
      <label class="form-check-label" :for="id">
        {{ localHeaderItem.customer_name }}
      </label>
    </td>
    <td>
      <label class="form-check-label" :for="id">
        {{ localHeaderItem.customer_reference_number }}
      </label>
    </td>
    <!-- <td>{{ localHeaderItem.customer_address }}</td> -->
    <td>
      <label class="form-check-label" :for="id">{{
        localHeaderItem.contact_number
      }}</label>
    </td>
    <td>
      <label class="form-check-label" :for="id">{{
        localHeaderItem.prepared_by
      }}</label>
    </td>
    <td>
      <label class="form-check-label" :for="id">{{
        localHeaderItem.authorized_by
      }}</label>
    </td>
    <td>
      <label class="form-check-label" :for="id">{{
        localHeaderItem.status.status
      }}</label>
    </td>
    <td>
      <action-buttons
        :localHeaderItem="localHeaderItem"
        @delete-cpo="deleteCpo"
        @show-pdf-history="printCPOPdf"
      />
    </td>
  </tr>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import ActionButtons from "./ActionButtons.vue";
import {
  formatShortDate,
  isToday,
  formatDateTimeOnly,
} from "../../utils/dateUtils";
export default {
  components: {
    ActionButtons,
  },
  props: ["headerItem"],
  emits: ["delete-cpo", "deleted-cpo", "show-pdf-history"],

  data() {
    return {
      localHeaderItem: this.headerItem,
      isSelected: false,
      isDeleted: false,
      isDeleteCpo: false,
      isRemovedTr: false,
    };
  },
  watch: {
    isDeletedx(value) {
      if (value) {
        setTimeout(() => {
          this.isRemovedTr = true;
          this.$emit("deleted-cpo", { id: this.headerItem.id });
        }, 1000);
      }
    },
    isSelectedDeleted(value) {
      if (value) {
        this.deleteRow();
      }
    },
    isStatusUpdated(value) {
      if (value) {
        setTimeout(() => {
          this.updateSelectedCpoStatus({
            id: this.headerItem.id,
            isStatusUpdated: false,
          });
          this.getUpdatedHeader();
        }, 1000);
      }
    },
  },
  computed: {
    ...mapGetters("cpo", ["deletedCpos", "getSelectedPos"]),
    formattedDate() {
      return formatShortDate(this.localHeaderItem.created_at);
    },
    isToday() {
      return isToday(this.localHeaderItem.created_at);
    },
    formatDateTimeOnly() {
      return formatDateTimeOnly(this.localHeaderItem.created_at);
    },
    isDeletedx() {
      if (this.deletedCpos.find((item) => item.id === this.headerItem.id)) {
        return true;
      }

      return false;
    },

    trClasses() {
      return {
        // "table-secondary": this.localHeaderItem.locked,
        blink: this.isStatusUpdated && !this.isDeletedx,
        "table-success": this.isStatusUpdated && !this.isDeletedx,
        "table-danger": this.isDeletedx,
        // "tr-exit": this.isDeletedx,
      };
    },
    selectedPos() {
      const selectedPos = this.getSelectedPos;
      return selectedPos;
    },
    isStatusUpdated() {
      const selectedPos = this.getSelectedPos;
      const selectedItem = selectedPos.find(
        (item) => item.id === this.headerItem.id
      );
      if (selectedItem) {
        return selectedItem.isStatusUpdated;
      }

      return null;
    },

    isSelectedDeleted() {
      const selectedPos = this.getSelectedPos;
      const selectedItem = selectedPos.find(
        (item) => item.id === this.headerItem.id
      );
      if (selectedItem) {
        return selectedItem.isDeleted;
      }

      return null;
    },

    id() {
      return "select-po-" + this.localHeaderItem.id;
    },
    editHeaderLink() {
      if (this.$store.getters["auth/loggedUser"].is_admin) {
        return "admin-edit-cpo";
      }

      return "edit-cpo";
    },
    // isSelected() {
    //     return $store.getters["cpo/getSelectedPos"];
    // },
  },

  methods: {
    ...mapActions("cpo", [
      "addSelectedPo",
      "removeSelectedPo",
      "updateSelectedCpoStatus",
    ]),
    deleteRow() {
      this.isDeleted = true;
      setTimeout(() => {
        this.unselectPo();
        this.isRemovedTr = true;
      }, 1000);
    },

    async getUpdatedHeader() {
      const res = await axios.get("api/cpo/" + this.localHeaderItem.id);
      if (res.data) {
        this.localHeaderItem = res.data.cpo;
        // console.log(res.data.cpo);
      }
    },
    selectPo() {
      if (this.isSelected) {
        this.addSelectedPo({
          id: this.localHeaderItem.id,
          row: this.localHeaderItem,
          isStatusUpdated: false,
          isDeleted: false,
        });
      } else {
        this.unselectPo();
      }

      // this.$store.commit("cpo/updateSelectedCpoStatus", {
      //     id: this.headerItem.id,

      //     isStatusUpdated: true,
      // });
    },
    deleteCpo() {
      // console.log("emit");
      this.$emit("delete-cpo", { id: this.headerItem.id });
      // this.isDeleteCpo = true;
      // this.$emit("open-delete-cpo", this.localHeaderItem.id);
      // // open modal
      // const res = await axios.post("/repairs/api/cpo/destroy", {
      //     cpoId: this.localHeaderItem.id,
      // });
      // if (res.data) {
      //     this.unselectPo();
      //     this.isDeleted = true;
      //     // this.$emit("delete-cpo");
      // }
    },
    unselectPo() {
      this.removeSelectedPo({
        id: this.localHeaderItem.id,
      });
    },

    printCPOPdf() {
      // this.$emit("show-pdf-history", { id: this.localHeaderItem.id });
      window.location.href =
        this.linkGeneratePdf + "/?id=" + this.localHeaderItem.id;
    },

    isCurrentlySelected() {
      const selectedPos = this.getSelectedPos;
      const selectedItem = selectedPos.find(
        (num) => num.id === this.localHeaderItem.id
      );
      if (selectedItem) {
        this.isSelected = true;
      }
    },
  },
  mounted() {
    // console.log(this.localHeaderItem);
    this.isCurrentlySelected();
    // this.isSelected = true;
  },
};
</script>

<style scoped>
label {
  font-weight: normarl;
}
tr:hover {
  font-weight: bold;
}

label:hover {
  cursor: pointer;
}
.tr-exit {
  animation: trExit 0.5s forwards;
}
@keyframes trExit {
  0% {
    opacity: 1;

    transform: translateX(0);
  }
  50% {
    opacity: 0.5;
  }
  100% {
    opacity: 0;
    transform: translateX(-50px);
  }
}

.blink {
  animation: blink 0.5s linear;
}
@keyframes blink {
  0% {
    opacity: 0;
    transform: translateX(-50px);
  }
  50% {
    opacity: 0.5;
  }
  100% {
    opacity: 1;

    transform: translateX(0);
  }
}
</style>
