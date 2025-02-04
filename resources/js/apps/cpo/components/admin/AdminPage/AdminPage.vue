<template>
  <div class="row flex-nowrap">
    <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
      <side-bar></side-bar>
    </div>
    <div class="col p-1" style="margin-bottom: 200px">
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
export default {
  components: { PageFooter },
};
</script>

<style></style>
PageFooter
