<template>
  <tr class="bg-light">
    <td colspan="2" class="text-right">
      <strong class="text-danger fw-bold">TOTAL AMOUNT: </strong>
    </td>
    <td>
      <strong>{{ formTotal }}</strong>
    </td>
    <td colspan="2" class="text-right">
      <strong class="text-danger fw-bold">TOTAL QTY RETURNED: </strong>
    </td>
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
        .reduce(
          (acc, line) => acc + (+line.price || 0) * (+line.qty_returned || 0),
          0
        )
        .toFixed(2);
    },
    totalQtyReturned() {
      return this.lines.reduce((acc, line) => acc + +line.qty_returned || 0, 0);
    },
  },
};
</script>

<style scoped>
.text-right {
  text-align: right; /* Align text to the right */
}
</style>