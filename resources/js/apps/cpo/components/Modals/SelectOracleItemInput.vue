<template>
  <base-modal :modal-size="'xl'">
    <template #header>
      <h5 class="modal-title text-white">
        <strong> PLEASE SELECT ORACLE ITEM</strong>
      </h5>
      <button
        type="button"
        class="btn-close"
        @click="$emit('close-modal')"
      ></button>
    </template>
    <template #body>
      <div style="min-height: 500px">
        <form>
          <div class="mb-3">
            <input
              type="text"
              class="form-control"
              placeholder="Search Oracle Code or Description"
              v-model="searchOracleItemStr"
              @input="debouncedSearch"
            />
          </div>
        </form>
        <div style="max-height: 500px; overflow-y: auto">
          <spinner-loading v-if="isSearching" />
          <table
            class="table table-sm table-hover table-striped"
            v-if="!isSearching && items.length > 0"
          >
            <thead
              class="table-primary"
              style="position: sticky; top: 0; z-index: 1"
            >
              <tr>
                <th scope="col">ORACLE CODE</th>
                <th scope="col">DESCRIPTION</th>
                <th scope="col">UNIT</th>
                <th scope="col">PRICE</th>

                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="item in items"
                :key="item.id"
                :class="{
                  'table-warning':
                    currentlyViewingItem?.inventory_item_id ==
                    item.inventory_item_id,
                }"
              >
                <td>
                  {{ item.oracle_code }}
                </td>
                <td>{{ item.description }}</td>
                <td>{{ item.primary_unit_of_measure }}</td>
                <td>{{ item.list_price }}</td>

                <td>
                  <button
                    type="button"
                    class="btn btn-info mx-1"
                    @click="selectAndClose(item)"
                  >
                    <span class="nowrap">
                      <i class="bi bi-hand-index-thumb"></i>
                      SELECT
                    </span>
                  </button>
                  <button
                    type="button"
                    class="btn btn-warning mx-1"
                    @click="gotoYP(item)"
                  >
                    <span class="nowrap">
                      VIEW IN YP
                      <i class="bi bi-arrow-right"></i>
                    </span>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
          <h1 v-if="!isSearching && items.length == 0">NO ITEMS FOUND</h1>
        </div>
      </div>
    </template>
    <template #default>
      <p class="text-muted">
        <i class="bi bi-arrow-right"></i>
        <strong>VIEW IN YP</strong>: Please make sure to login to YellowPage
        first to view the item. Otherwise, you will be redirected to the login
        page.
      </p>
      <button
        type="button"
        class="btn btn-danger"
        @click="$emit('close-modal')"
      >
        CLOSE
      </button>
    </template>
  </base-modal>
</template>

<script>
import debounce from "lodash/debounce";
import SpinnerLoading from "../UI/SpinnerLoading.vue";
import { mapGetters } from "vuex";
export default {
  components: { SpinnerLoading },
  data() {
    return {
      items: [],
      searchOracleItemStr: "",
      isSearching: false,
      currentlyViewingItem: null,
    };
  },
  computed: {
    ...mapGetters("auth", ["isAdmin"]),
  },

  methods: {
    gotoYP(item) {
      this.currentlyViewingItem = item;
      const url = `http://113.1.1.190/phase7/stockstatus.php?itemcode=&itemcode2=&oc=${item.oracle_code}&inventory_item_id=${item.inventory_item_id}`;
      window.open(url, "_blank");
    },
    selectAndClose(item) {
      this.$emit("item-selected", item);
    },
    async searchOracleItem() {
      if (this.isSearching) return;
      try {
        this.isSearching = true;
        const res = await axios.get("api/items/all", {
          params: {
            search: this.searchOracleItemStr,
          },
        });
        this.items = res.data.items;
        // console.log(this.items);
      } catch (error) {
        console.error(error);
      } finally {
        this.isSearching = false;
      }
    },
  },
  mounted() {
    this.$nextTick(() => {
      this.$el.querySelector('input[type="text"]').focus();
    });

    this.searchOracleItem();
  },
  created() {
    this.debouncedSearch = debounce(this.searchOracleItem, 500);
  },
};
</script>

<style></style>
