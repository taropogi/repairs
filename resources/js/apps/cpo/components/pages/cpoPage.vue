<template>
  <div class="row flex-nowrap">
    <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
      <side-bar></side-bar>
    </div>
    <div
      class="col p-1"
      :class="{
        'has-margin': !isNavSearchActive,
      }"
    >
      <router-view v-slot="slotProps">
        <transition name="router" mode="out-in">
          <component :is="slotProps.Component"></component>
        </transition>
      </router-view>
      <page-footer></page-footer>
    </div>
  </div>
</template>

<script>
import pageFooter from "./pageFooter.vue";
import { mapGetters } from "vuex";
export default {
  components: { pageFooter },
  computed: {
    ...mapGetters(["activeNav"]),
    isNavSearchActive() {
      return this.activeNav?.nav === "search-cpo" ? true : false;
    },
  },
};
</script>

<style>
.has-margin {
  margin-bottom: 200px;
}
.router-enter-from {
  opacity: 0;

  transform: translateY(-30px);
}
.router-enter-active {
  transition: all 0.3s ease-out;
}
.router-enter-to {
  opacity: 1;

  transform: translateY(0);
}
.router-leave-from {
  opacity: 1;
  transform: translateY(0);
}
.router-leave-active {
  transition: all 0.3s ease-out;
}
.router-leave-to {
  opacity: 0;
  transform: translateY(30px);
}
</style>
