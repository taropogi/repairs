<template>
  <tr :class="{ blink: isUpdated, 'blink-deleted': isDeleted }">
    <th scope="row">{{ localLineDetails.line_number }}</th>
    <td>
      <item-input-description
        v-model="localLineDetails.description"
        :is-disabled="
          isDisabled ||
          !(editLineFieldsPermission.includes('description') || isAdmin)
        "
        @select-item-for="
          $emit('select-item-for', localLineDetails.line_number)
        "
        @item-searched="
          (item) => {
            localLineDetails.unit =
              item?.primary_uom_code ?? localLineDetails.unit;
          }
        "
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control"
        v-model="localLineDetails.price"
        :disabled="
          isDisabled || !(editLineFieldsPermission.includes('price') || isAdmin)
        "
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control"
        :disabled="
          isDisabled ||
          !(editLineFieldsPermission.includes('order_number') || isAdmin)
        "
        v-model="localLineDetails.order_number"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control"
        v-model="localLineDetails.hcopy"
        :disabled="
          isDisabled || !(editLineFieldsPermission.includes('hcopy') || isAdmin)
        "
      />
    </td>
    <td>
      <input
        type="number"
        class="form-control"
        v-model="localLineDetails.qty_returned"
        :disabled="
          isDisabled ||
          !(editLineFieldsPermission.includes('qty_returned') || isAdmin)
        "
      />
    </td>
    <td>
      <div
        v-if="
          (itemsUom.length > 0 && editLineFieldsPermission.includes('unit')) ||
          isAdmin
        "
      >
        <select
          class="form-select"
          v-model="localLineDetails.unit"
          :disabled="isDisabled"
        >
          <option
            v-for="uom in itemsUom"
            :key="uom"
            :value="uom.primary_uom_code"
          >
            {{ uom.primary_uom_code }} - {{ uom.primary_unit_of_measure }}
          </option>
        </select>
      </div>
      <span v-else>
        <input
          type="text"
          class="form-control"
          :disabled="true"
          v-model="localLineDetails.unit"
        />
      </span>
    </td>
    <td>
      <input
        type="number"
        class="form-control"
        v-model="localLineDetails.qty_inspect"
        :disabled="
          isDisabled ||
          !(editLineFieldsPermission.includes('qty_inspect') || isAdmin)
        "
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control"
        :disabled="
          isDisabled || !(editLineFieldsPermission.includes('date') || isAdmin)
        "
        v-model="localLineDetails.date"
      />
    </td>
    <td>
      <input
        type="number"
        class="form-control"
        :disabled="
          isDisabled ||
          !(editLineFieldsPermission.includes('good_condition') || isAdmin)
        "
        v-model="localLineDetails.good_condition"
      />
    </td>
    <td>
      <input
        type="number"
        class="form-control"
        :disabled="
          isDisabled ||
          !(editLineFieldsPermission.includes('minor_repair_clean') || isAdmin)
        "
        v-model="localLineDetails.minor_repair_clean"
      />
    </td>
    <td>
      <input
        type="number"
        class="form-control"
        :disabled="
          isDisabled ||
          !(editLineFieldsPermission.includes('repair_parts_needed') || isAdmin)
        "
        v-model="localLineDetails.repair_parts_needed"
      />
    </td>
    <td>
      <input
        type="number"
        class="form-control"
        :disabled="
          isDisabled ||
          !(editLineFieldsPermission.includes('damaged') || isAdmin)
        "
        v-model="localLineDetails.damaged"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control"
        :disabled="isDisabled"
        v-model="localLineDetails.user_comment"
        v-if="editLineFieldsPermission.includes('comments') || isAdmin"
      />

      <div v-if="localLineDetails.other_comments.length > 0">
        <div
          class="my-0"
          v-for="comment in localLineDetails.other_comments"
          :key="comment.id"
        >
          <p class="m-0 p-0 text-sm" v-if="comment.comment.trim() !== ''">
            <strong class="text-danger text-sm"
              >{{ comment.commented_by }}:</strong
            >
            {{ comment.comment }}
          </p>
        </div>
      </div>
      <p
        class="text-muted"
        v-if="
          lineDetails.other_comments.length == 0 &&
          !(editLineFieldsPermission.includes('comments') || isAdmin)
        "
      >
        Others' comments will show here
      </p>
    </td>

    <td v-if="canEditCpo">
      <span class="badge bg-secondary" v-if="headerIsLocked">LOCKED</span>
      <div class="nowrap" v-else>
        <button
          type="button"
          class="btn btn-primary py-1 mx-1"
          @click="saveLine"
          :disabled="lineUpdating || isDeleting"
        >
          <span v-if="!lineUpdating" class="nowrap">
            <i class="bi bi-save"></i>
            Save</span
          >
          <span v-else class="spinner-border spinner-border-sm"> </span>
        </button>

        <button
          type="button"
          class="btn btn-danger py-1"
          @click="deleteLine"
          :disabled="lineUpdating || isDeleting"
        >
          <span v-if="!isDeleting" class="nowrap">
            <i class="bi bi-trash"></i>
            Delete</span
          >
          <span class="spinner-border spinner-border-sm" v-else></span>
        </button>
      </div>
    </td>
  </tr>
</template>

<script>
import debounce from "lodash/debounce";
import ItemInputDescription from "../UI/ItemInputDescription.vue";
import { mapGetters } from "vuex";
export default {
  props: ["lineDetails", "headerIsLocked", "itemsUom"],
  components: { ItemInputDescription },
  watch: {
    lineDetails: {
      handler(updatedLine) {
        this.localLineDetails = { ...updatedLine };
        console.log("lineDetails changed");
      },
      deep: true,
    },
    localLineDetails: {
      handler(updatedLine, oldLine) {
        console.log("oldLine", oldLine);
        console.log("updatedLine", updatedLine);
        this.$emit("saveLine", updatedLine);
        // this.localLineDetails = { ...this.lineDetails };
        console.log("localLineDetails changed");
      },
      deep: true,
    },
    // localLineDetails: {
    //   handler(updatedLine) {
    //     this.$emit("saveLine", updatedLine);
    //     console.log(updatedLine);
    //   },
    //   deep: true,
    // },
  },

  data() {
    return {
      localLineDetails: { ...this.lineDetails },
      lineUpdating: false,
      isDeleted: false,
      isDeleting: false,
      isUpdated: false,
      isSearchingSegment6: false,
    };
  },
  inject: ["showNotification"],
  emits: ["deleteLine", "saveLine", "select-item-for"],
  computed: {
    ...mapGetters("auth", [
      "canEditCpo",
      "editLineFieldsPermission",
      "isAdmin",
    ]),
    isDisabled() {
      return (
        this.headerIsLocked ||
        !this.canEditCpo ||
        this.lineUpdating ||
        this.isDeleting
      );
    },
    showTr() {
      return !this.lineUpdating;
    },
  },
  created() {
    this.debouncedSearchItemSegment6 = debounce(
      this.searchOracleItemSegment6,
      500
    );
  },
  methods: {
    async searchOracleItemSegment6() {
      const segment6 = this.localLineDetails.description;
      if (this.isSearchingSegment6) return;
      try {
        this.isSearchingSegment6 = true;
        const res = await axios.get("api/items/segment6/single", {
          params: {
            search: segment6,
          },
        });
        this.localLineDetails.description =
          res.data.item?.description || this.localLineDetails.description;
        // this.localLineDetails.price =
        //   res.data.item?.list_price || this.localLineDetails.price;
        this.localLineDetails.unit =
          res.data.item?.primary_uom_code || this.localLineDetails.unit;

        if (res.data.item) {
          this.showNotification({
            message: `Item found for segment6: ${segment6}`,
            type: "success",
          });
        }

        this.$emit("saveLine", this.localLineDetails);
        // this.items = res.data.items;
        // console.log(this.items);
      } catch (error) {
        console.error(error);
      } finally {
        this.isSearchingSegment6 = false;
      }
    },
    blinkTr(isDelete = false) {
      if (isDelete) {
        this.isDeleted = true;
      } else {
        this.isUpdated = true;
      }

      setTimeout(
        () => {
          if (isDelete) {
            // this.isDeleted = false;
          } else {
            this.isUpdated = false;
          }

          if (isDelete) {
            this.$emit("deleteLine", this.localLineDetails.id);
          }
        },
        isDelete ? 500 : 2000
      ); // 1 second
    },
    async saveLine() {
      //locally save
      this.lineUpdating = true;
      // console.log(this.lineDetails);
      try {
        const res = await axios.post(
          "api/cpoline/update/",
          this.localLineDetails
        );
        this.blinkTr();
        this.showNotification({
          message: `Line# ${this.lineDetails.line_number} has been updated`,
          type: "success",
        });
        // console.log(res);
      } catch (error) {
        console.log(error.message);
      } finally {
        this.lineUpdating = false;
      }

      // this.$emit("saveLine", this.lineDetailsLocal);
    },
    async deleteLine() {
      try {
        this.isDeleting = true;
        await axios.post("api/cpoline/destroy/", {
          id: this.localLineDetails.id,
        });

        this.blinkTr(true);
        this.showNotification({
          message: `Line# ${this.localLineDetails.line_number} has been deleted`,
          type: "error",
        });
      } catch (error) {
        console.log(error.message);
      } finally {
        this.isDeleting = false;
      }
    },
  },
};
</script>

<style scoped>
@keyframes blink-deleted {
  0% {
    background-color: transparent;
  }
  50% {
    background-color: red;
  }
  100% {
    background-color: transparent;
  }
}

.blink-deleted {
  animation: blink-deleted 0.5s ease-in-out;
}

@keyframes blink {
  0% {
    background-color: transparent;
  }
  50% {
    background-color: rgba(40, 167, 69, 1);
  }
  100% {
    background-color: transparent;
  }
}

.blink {
  animation: blink 2s ease-in-out;
}
</style>
