<template>
  <div
    class="form-check mb-2"
    v-for="(lineField, index) in lineFields"
    :key="lineField.dbField + 'encode-line-key'"
  >
    <input
      class="form-check-input"
      type="checkbox"
      :id="lineField.dbField + 'encode-line-input'"
      :value="lineField.dbField"
      :name="'lineFieldsEncode' + index"
      :checked="cpoEncodeLineFields.includes(lineField.dbField)"
      v-model="cpoEncodeLineFields"
    />
    <label
      class="form-check-label ms-2"
      :for="lineField.dbField + 'encode-line-input'"
    >
      {{ lineField.description }}
    </label>
  </div>
</template>

<script>
export default {
  emits: ["update:modelValue"],
  props: {
    lineFields: {
      type: Array,
      required: true,
    },
    modelValue: {
      type: Array,
      required: true,
    },
  },
  watch: {
    cpoEncodeLineFields: function (newVal) {
      this.$emit("update:modelValue", newVal);
    },
  },
  data() {
    return {
      cpoEncodeLineFields: this.modelValue,
    };
  },
};
</script>

<style></style>
