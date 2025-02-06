<template>
  <tr class="bg-light">
    <td colspan="2" class="text-right">
      <strong class="text-danger fw-bold">TOTAL AMOUNT : </strong>
    </td>
    <td
      :class="{ wiggle: isWigglingTotal }"
      @animationend="isWigglingTotal = false"
    >
      <strong>{{ formTotal }}</strong>
    </td>
    <td colspan="3" class="text-right">
      <strong class="text-danger fw-bold">TOTAL QTY RETURNED: </strong>
    </td>
    <td
      :class="{ wiggle: isWigglingQtyReturned }"
      @animationend="isWigglingQtyReturned = false"
    >
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
  data() {
    return {
      isWigglingTotal: false,
      isWigglingQtyReturned: false,
    };
  },
  watch: {
    formTotal() {
      this.isWigglingTotal = true;
    },
    totalQtyReturned() {
      this.isWigglingQtyReturned = true;
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

@keyframes wiggle {
  0%,
  100% {
    transform: rotate(0deg);
  }
  10% {
    transform: rotate(-10deg);
  }
  20% {
    transform: rotate(10deg);
  }
  30% {
    transform: rotate(-10deg);
  }
  40% {
    transform: rotate(10deg);
  }
  50% {
    transform: rotate(-10deg);
  }
  60% {
    transform: rotate(10deg);
  }
  70% {
    transform: rotate(-10deg);
  }
  80% {
    transform: rotate(10deg);
  }
  90% {
    transform: rotate(-10deg);
  }
}

.wiggle {
  animation: wiggle 1s ease-in-out;
}
</style>
