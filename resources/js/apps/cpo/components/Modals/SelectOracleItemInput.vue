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
                <th v-if="isAdmin">Images</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in items" :key="item.id">
                <td>
                  {{ item.oracle_code }}
                </td>
                <td>{{ item.description }}</td>
                <td>{{ item.primary_unit_of_measure }}</td>
                <td>{{ item.list_price }}</td>
                <td v-if="isAdmin">
                  <div v-if="item.filtered_image_urls.length > 0">
                    <img
                      v-for="(url, index) in item.filtered_image_urls"
                      :key="index"
                      :src="url"
                      alt="item image"
                      style="width: 50px; height: 50px; margin-right: 5px"
                    />
                  </div>
                </td>
                <td>
                  <button
                    type="button"
                    class="btn btn-primary"
                    @click="selectAndClose(item)"
                  >
                    SELECT
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
    };
  },
  computed: {
    ...mapGetters("auth", ["isAdmin"]),
  },

  methods: {
    async filterImageUrls(item) {
      const filteredUrls = [];
      for (const url of item.image_urls) {
        const exists = await this.checkImageExists(url);
        if (exists) {
          filteredUrls.push(url);
        }
      }
      this.$set(item, "filtered_image_urls", filteredUrls);
    },
    async checkImageExists(url) {
      try {
        const response = await fetch(url, { method: "HEAD" });
        return response.ok;
      } catch (error) {
        console.error("Error checking image:", error);
        return false;
      }
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
