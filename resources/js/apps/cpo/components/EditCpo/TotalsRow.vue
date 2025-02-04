<template>
  <tr class="bg-light">
    <td colspan="2">
      <strong>Total</strong>
    </td>
    <td>
      <strong>Php {{ formTotal }}</strong>
    </td>
    <td colspan="2"></td>
    <td>
      <strong>{{ totalQtyReturned }}</strong>
    </td>
  </tr>
</template>

<script>
export default {
  props: {
    lines: {
      type: Array,
      required: true,
    },
  },
  computed: {
    formTotal() {
      return this.lines
        .reduce((acc, line) => acc + +line.price || 0, 0)
        .toFixed(2);
    },
    totalQtyReturned() {
      return this.lines.reduce((acc, line) => acc + +line.qty_returned || 0, 0);
    },
  },
};
</script>

<style>
</style>