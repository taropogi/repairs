<template>
  <tr
    :class="{
      'table-warning':
        currentlyViewingItem?.inventory_item_id == item.inventory_item_id,
    }"
  >
    <td>
      <div v-if="item?.image_urls.length > 0">
        <span v-for="(url, index) in item.image_urls" :key="index">
          <item-image :url="url" />
        </span>
      </div>
    </td>
    <td>
      <span class="fw-bold">{{ oracleCode }} </span>
    </td>
    <td>
      {{ item.description }}

      <span
        v-if="item.inventory_item_status_code == 'Inactive'"
        class="badge bg-warning text-dark"
        >{{ item.inventory_item_status_code }}</span
      >
    </td>
    <td>{{ item.primary_unit_of_measure }}</td>
    <td>{{ item.list_price }}</td>

    <td class="nowrap">
      <button
        type="button"
        class="btn btn-info mx-1 btn-sm"
        @click="selectItem"
        style="padding: 2px 6px; font-size: 12px"
      >
        <span class="nowrap fw-bold" style="font-size: 12px">
          <i class="bi bi-hand-index-thumb" style="font-size: 10px"></i>
          SELECT
        </span>
      </button>
      <button
        type="button"
        class="btn btn-warning mx-1 btn-sm"
        @click="gotoYP"
        style="padding: 2px 6px; font-size: 12px"
      >
        <span class="nowrap fw-bold" style="font-size: 12px">
          VIEW IN YP
          <i class="bi bi-arrow-right" style="font-size: 10px"></i>
        </span>
      </button>
    </td>
  </tr>
</template>

<script>
import ItemImage from "./ItemImage.vue";
export default {
  inject: ["appVersion"],
  props: {
    item: {
      type: Object,
      required: true,
    },

    currentlyViewingItem: {
      type: Object,
      default: null,
    },
  },
  components: { ItemImage },

  computed: {
    oracleCode() {
      return `${this.item.segment1}-${this.item.segment2}-${this.item.segment3}-${this.item.segment4}-${this.item.segment5}-${this.item.segment6}`;
    },
  },

  methods: {
    selectItem() {
      this.logSelectItem();
      this.$emit("select-item", this.item);
    },
    gotoYP() {
      const item = this.item;
      this.$emit("goto-yp", item);
      this.logClickedGoto();
      const url = `http://113.1.1.190/phase7/stockstatus.php?itemcode=&itemcode2=&oc=${item.oracle_code}&inventory_item_id=${item.inventory_item_id}`;
      window.open(url, "_blank");
    },
    async logSelectItem() {
      try {
        await axios.post("/api/log/selectItem", {
          action: "selectItem",
          item: this.item,
          appVersion: this.appVersion,
        });
      } catch (error) {
        console.error("Error logging action:", error);
      }
    },
    async logClickedGoto() {
      try {
        await axios.post("/api/log/gotoYp", {
          action: "gotoYP",
          item: this.item,
        });
      } catch (error) {
        console.error("Error logging action:", error);
      }
    },
  },
  mounted() {
    // console.log(this.item.image_urls);
  },
};
</script>

<style></style>
