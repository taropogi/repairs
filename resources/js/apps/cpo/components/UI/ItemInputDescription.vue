<template>
  <div class="input-group">
    <input
      @input="debouncedSearchItemSegment6"
      type="text"
      class="form-control"
      v-model="modelValue"
      :disabled="isDisabled"
    />
    <button
      v-if="!isDisabled"
      class="btn btn-secondary btn-sm py-0"
      type="button"
      @click="$emit('select-item-for')"
    >
      <i class="fas fa-box-open"></i>
      ...
    </button>
  </div>
</template>

<script>
import { debounce } from "lodash";
export default {
  inject: ["showNotification"],
  props: {
    modelValue: {
      type: String,
      required: false,
      default: "",
    },
    isDisabled: {
      type: Boolean,
      required: false,
      default: false,
    },
  },
  data() {
    return {
      isSearchingSegment6: false,
      itemSearched: null,
    };
  },
  emits: ["update:modelValue", "item-searched", "select-item-for"],
  watch: {
    modelValue() {
      this.$emit("update:modelValue", this.modelValue);
    },
  },
  methods: {
    async searchOracleItemSegment6() {
      const segment6 = this.modelValue;
      if (this.isSearchingSegment6) return;
      try {
        this.isSearchingSegment6 = true;
        const res = await axios.get("api/items/segment6/single", {
          params: {
            search: segment6,
          },
        });
        // console.log(res.data.item?.description || this.modelValue);
        this.$emit(
          "update:modelValue",
          `${res.data.item?.description} - ${segment6}` || this.modelValue
        );

        if (res.data.item) {
          this.itemSearched = res.data.item;
          this.$emit("item-searched", this.itemSearched);

          // console.log(this.itemSearched.primary_uom_code);
          this.showNotification({
            message: `Item found for segment6: ${segment6}`,
            type: "success",
          });
        }
        // this.items = res.data.items;
        // console.log(this.items);
      } catch (error) {
        console.error(error);
      } finally {
        this.isSearchingSegment6 = false;
      }
    },
  },
  created() {
    this.debouncedSearchItemSegment6 = debounce(
      this.searchOracleItemSegment6,
      500
    );
  },
};
</script>