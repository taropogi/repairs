<template>
  <div>
    <spinner-loading v-if="!oracleCustomers"></spinner-loading>
    <main class="container-fluid" v-else>
      <div :class="{ backdrop: showBackDrop }"></div>

      <router-view v-slot="slotProps">
        <transition name="app-router" mode="out-in">
          <component :is="slotProps.Component"></component>
        </transition>
      </router-view>
    </main>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import { computed } from "vue";

export default {
  data() {
    return { laravelData: null };
  },
  methods: {
    ...mapActions(["setShowBackDrop", "setOracleCustomers"]),
    ...mapActions("auth", ["tryLogin"]),
  },
  computed: {
    ...mapGetters(["showBackDrop", "oracleCustomers"]),
  },
  provide() {
    return {
      setShowBackDrop: this.setShowBackDrop,
      laravelData: computed(() => this.laravelData),
    };
  },
  created() {
    this.tryLogin();
  },
  mounted() {
    this.$store.commit("setLaravelData", window.laravelData); // laravel data from layouts.app.blade.php
    this.laravelData = window.laravelData;
    this.setOracleCustomers();
  },
};
</script>

<style>
.modal {
  z-index: 10001;
}
.backdrop {
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  width: 100%;
  background-color: rgba(0, 0, 0, 0.75);
  z-index: 10000;
  opacity: 0.8;
}

* {
  font-size: 12px;
}

.app-router-enter-from {
  opacity: 0;
  transform: translateY(-30px);
}
.app-router-enter-active {
  transition: all 0.3s ease-out;
}
.app-router-enter-to {
  opacity: 1;
  transform: translateY(0);
}
.app-router-leave-from {
  opacity: 1;
  transform: translateY(0);
}
.app-router-leave-active {
  transition: all 0.3s ease-out;
}
.app-router-leave-to {
  opacity: 0;
  transform: translateY(-30px);
}

label {
  font-weight: bold;
}
</style>
