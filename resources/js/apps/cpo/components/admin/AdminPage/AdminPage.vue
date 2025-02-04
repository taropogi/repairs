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
import PageFooter from "../../pages/pageFooter.vue";
import { mapGetters } from "vuex";
export default {
  components: { PageFooter },
  computed: {
    ...mapGetters(["activeNav"]),
    isNavSearchActive() {
      return this.activeNav?.nav === "search-cpo" ? true : false;
    },
  },
};
</script>

<style scoped>
.has-margin {
  margin-bottom: 200px;
}
</style> 