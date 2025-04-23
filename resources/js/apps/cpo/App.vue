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
import { useToast } from "vue-toastification";

export default {
  data() {
    return {
      laravelData: null,
      hasReloaded: false,
      pageReloadId: null,
      appVersion: "2025-04-23",
    };
  },
  methods: {
    ...mapActions(["setShowBackDrop", "setOracleCustomers"]),
    ...mapActions("auth", ["tryLogin"]),
    checkReload() {
      this.pageReloadId = setInterval(() => {
        const now = new Date();
        const targetHour = 12;
        const targetMinute = 15;
        //test
        // const targetHour = 10;
        // const targetMinute = 52;

        console.log("Checking for reload...");

        if (
          now.getHours() === targetHour &&
          now.getMinutes() === targetMinute &&
          !this.hasReloaded
        ) {
          location.reload();
          this.hasReloaded = true; // Set the flag to true after reloading
        } else if (
          now.getHours() > targetHour ||
          (now.getHours() === targetHour && now.getMinutes() > targetMinute)
        ) {
          this.hasReloaded = true; // Set the flag to true if the target time has passed
        }
      }, 60000); // 60000 means 1 minute
    },
  },
  computed: {
    ...mapGetters(["showBackDrop", "oracleCustomers"]),
  },
  watch: {
    hasReloaded(newVal) {
      if (newVal && this.pageReloadId) {
        clearInterval(this.pageReloadId);
        console.log("Page reload interval cleared.");
        this.pageReloadId = null;
      }
    },
  },
  provide() {
    return {
      appVersion: this.appVersion,
      setShowBackDrop: this.setShowBackDrop,
      laravelData: computed(() => this.laravelData),
      showNotification(toastData) {
        const toast = useToast();
        const { message, type = "success" } = toastData;

        if (type === "success") toast.success(message);
        if (type === "info") toast.info(message);
        if (type === "warning") toast.warning(message);
        if (type === "error") toast.error(message);
      },
      logPageVisit: async (pageName) => {
        // console.log(this.appVersion);
        try {
          await axios.post("/api/log/page-visit", {
            page: pageName,
            appVersion: this.appVersion,
          });
        } catch (error) {
          console.log(error.message);
        }
      },
      logActivity: async (activity) => {
        try {
          await axios.post("/api/log/activity", {
            ...activity,
            appVersion: this.appVersion,
          });
        } catch (error) {
          console.log(error.message);
        }
      },
    };
  },
  created() {
    this.tryLogin();
  },
  mounted() {
    this.$store.commit("setLaravelData", window.laravelData); // laravel data from layouts.app.blade.php
    this.laravelData = window.laravelData;
    this.setOracleCustomers();
    this.checkReload();
  },
};
</script>

<style>
body {
  font-family: "Roboto", sans-serif;
}

.container-fluid {
  font-family: "Roboto", sans-serif;
}

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

.nowrap {
  white-space: nowrap;
}
.tooltip-wrapper {
  display: inline-block;
  position: relative;
}

/* Custom hover color for table rows */
.table-hover tbody tr:hover,
.bg-light-green {
  background-color: #d4edda;
}

.bg-light {
  background-color: #e9ecef !important;
}
</style>
