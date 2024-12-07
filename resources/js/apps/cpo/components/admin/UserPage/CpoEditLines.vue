<template>
  <div
    class="form-check mb-2"
    v-for="lineField in lineFields"
    :key="lineField.dbField + 'edit-line-key'"
  >
    <input
      class="form-check-input"
      type="checkbox"
      :id="lineField.dbField + 'edit-line-input'"
      :value="lineField.dbField"
      name="lineFieldsEdit"
      :checked="cpoEditLineFields.includes(lineField.dbField)"
      v-model="cpoEditLineFields"
    />
    <label
      class="form-check-label ms-2"
      :for="lineField.dbField + 'edit-line-input'"
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
    cpoEditLineFields: function (newVal) {
      this.$emit("update:modelValue", newVal);
    },
  },
  data() {
    return {
      cpoEditLineFields: this.modelValue,
    };
  },
};
</script>

<style></style>
