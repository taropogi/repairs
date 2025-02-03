<template>
  <tr
    :class="{
      'table-warning':
        currentlyViewingItem?.inventory_item_id == item.inventory_item_id,
    }"
  >
    <td>
      <span class="fw-bold">{{ item.oracle_code }} </span>

      <div v-if="item?.image_urls.length > 0">
        <span v-for="(url, index) in item.image_urls" :key="index">
          <item-image :url="url" />
        </span>
      </div>
    </td>
    <td>{{ item.description }}</td>
    <td>{{ item.primary_unit_of_measure }}</td>
    <td>{{ item.list_price }}</td>

    <td class="nowrap">
      <button
        type="button"
        class="btn btn-info mx-1 btn-sm"
        @click="selectItem"
      >
        <span class="nowrap fw-bold">
          <i class="bi bi-hand-index-thumb"></i>
          SELECT
        </span>
      </button>
      <button type="button" class="btn btn-warning mx-1 btn-sm" @click="gotoYP">
        <span class="nowrap fw-bold">
          VIEW IN YP
          <i class="bi bi-arrow-right"></i>
        </span>
      </button>
    </td>
  </tr>
</template>

<script>
import ItemImage from "./ItemImage.vue";
export default {
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
      // console.log(this.item);
      try {
        await axios.post("/api/log/selectItem", {
          action: "selectItem",
          item: this.item,
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
