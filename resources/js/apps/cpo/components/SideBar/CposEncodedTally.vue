<template>
  <div class="mt-4">
    <table
      class="table table-striped table-white table-bordered table-hover"
      v-if="canAccessOtherCpos && tally.length > 0"
    >
      <thead>
        <tr class="table-secondary">
          <th scope="col" colspan="2" class="text-center">
            TODAY'S ENCODED CPOS TALLY
          </th>
        </tr>
        <tr class="table-success">
          <th scope="col">DEPARTMENT</th>
          <th scope="col">COUNT</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in tally" :key="item.created_by">
          <th scope="row">
            {{ item.created_by_name.toUpperCase() }}
          </th>
          <td>
            {{ item.total }}
          </td>
        </tr>

        <tr class="table-success" :class="{ 'animate-total': animateTotal }">
          <th scope="row">TOTAL ENCODED</th>
          <td>{{ total }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  inject: ["showNotification"],
  data() {
    return {
      tally: [],
      canAccessOtherCpos: false,
      isInitialShow: true,
      intervalId: null,
    };
  },

  watch: {
    total(newVal, oldVal) {
      this.animateTotal = true;
      setTimeout(() => {
        this.animateTotal = false;
      }, 500);

      if (!this.isInitialShow) {
        if (newVal > oldVal) {
          this.showNotification({
            message: `New CPO Encoded. Total Encoded Today: ${this.total}`,
            type: "success",
          });
        } else {
          this.showNotification({
            message: `Some Cpo deleted. Total Encoded today: ${this.total}`,
            type: "error",
          });
        }
      }

      this.isInitialShow = false;
    },
  },

  computed: {
    total() {
      return this.tally.reduce((acc, item) => acc + item.total, 0);
    },
  },

  methods: {
    async fetchCpos() {
      try {
        const response = await axios.get("/api/cpo/cpos/tally");
        this.cpos = response.data;
        this.canAccessOtherCpos = response.data.canAccessOtherCpos;
        this.tally = response.data.tally;
        // console.log(this.cpos);
      } catch (error) {
        console.error(error);
      }
    },
  },
  mounted() {
    this.fetchCpos();

    this.intervalId = setInterval(() => {
      this.fetchCpos();
    }, 10000);
  },
  beforeUnmount() {
    // console.log("unmounted");
    clearInterval(this.intervalId);
  },
};
</script>

<style scoped>
@keyframes wiggle {
  0%,
  100% {
    transform: rotate(-3deg);
  }
  50% {
    transform: rotate(3deg);
  }
}

.animate-total {
  animation: wiggle 1s ease-in-out;
}

.table-white {
  background-color: white;
}
</style>