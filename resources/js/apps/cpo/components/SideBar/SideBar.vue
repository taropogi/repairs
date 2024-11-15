<template>
  <div class="min-vh-100 sticky-top d-flex flex-column" v-if="isLoggedIn">
    <img
      :src="laravelData.side_bar_image"
      class="img-fluid mt-3"
      style="width: 50%"
    />
    <!-- <h2 class="text-white mt-5 mb-0">Menu</h2> -->
    <hr class="text-white" />
    <ul class="nav nav-pills flex-column my-2">
      <li class="nav-item">
        <router-link
          :to="searchCpoLink"
          class="nav-link text-white"
          :class="{ active: isNavSearchActive || isNavUpdateActive }"
          ><i class="bi bi-search me-2"></i> Search CPO
          <span class="badge bg-success" v-if="isNavUpdateActive"
            >UPDATE PAGE <span v-if="!canEditCpo">(VIEW)</span></span
          >
        </router-link>
      </li>
      <li>
        <router-link
          :to="encodeCpoPageLink"
          class="nav-link text-white"
          :class="{ active: isNavEncodeActive }"
          ><i class="bi bi-pencil-square me-2"></i> Encode CPO</router-link
        >
      </li>
      <li>
        <router-link
          :to="linkExportCpo"
          class="nav-link text-white"
          :class="{ active: isNavExportActive }"
          ><i class="bi bi-box-arrow-up me-2"></i> Export CPO list</router-link
        >
      </li>
    </ul>

    <div v-if="userIsAdmin">
      <hr class="text-white" />
      <admin-links-user></admin-links-user>
      <hr class="text-white" />
      <admin-links-status></admin-links-status>
      <!-- <hr class="text-white" />
      <admin-links-permissions></admin-links-permissions> -->
    </div>

    <transition name="export-btns">
      <div v-if="isNavExportActive">
        <hr class="text-white" />
        <export-buttons></export-buttons>
      </div>
    </transition>
    <transition name="export-btns">
      <div v-if="selectedPosCount && isNavSearchActive">
        <hr class="text-white" />
        <multi-options> </multi-options>
      </div>
    </transition>

    <hr />
    <div class="mb-auto"></div>
    <user-options
      class="mb-0 p-5"
      :user="loggedUser"
      @logOut="logOut"
    ></user-options>
  </div>
</template>

<script>
import UserOptions from "./UserOptions.vue";
import ExportButtons from "./ExportButtons/ExportButtons.vue";
import MultiOptions from "./MultiOptions.vue";
import AdminLinksUser from "./AdminLinks/User.vue";
import AdminLinksStatus from "./AdminLinks/CpoStatus.vue";
import AdminLinksPermissions from "./AdminLinks/Permissions.vue";
import { mapGetters, mapActions } from "vuex";
export default {
  inject: ["laravelData"],
  components: {
    UserOptions,
    ExportButtons,
    MultiOptions,
    AdminLinksUser,
    AdminLinksStatus,
    AdminLinksPermissions,
  },
  data() {
    return {};
  },
  computed: {
    ...mapGetters(["activeNav"]),
    ...mapGetters("auth", ["isLoggedIn", "loggedUser", "canEditCpo"]),
    selectedPos() {
      return this.$store.getters["cpo/getSelectedPos"];
    },
    selectedPosCount() {
      return this.selectedPos.length;
    },

    isNavSearchActive() {
      if (this.activeNav?.nav === "search-cpo") {
        return true;
      }
      return false;
    },
    isNavUpdateActive() {
      if (this.activeNav?.nav === "edit-cpo") {
        return true;
      }
      return false;
    },
    isNavExportActive() {
      if (this.activeNav?.nav === "export-cpo") {
        return true;
      }
      return false;
    },
    isNavEncodeActive() {
      if (this.activeNav?.nav === "encode-cpo") {
        return true;
      }
      return false;
    },
    userIsAdmin() {
      return this.isLoggedIn && this.loggedUser?.is_admin;
    },
    userIsUser() {
      return this.isLoggedIn && !this.loggedUser?.is_admin;
    },
    mainPageHeader() {
      return this.$store.getters.mainPageTitleHeader;
    },
    loginPageLink() {
      return {
        name: "login-page",
      };
    },
    registerPageLink() {
      return {
        name: "register-page",
      };
    },
    cpoPageLink() {
      return {
        name: "cpo-page",
      };
    },
    linkExportCpo() {
      if (this.loggedUser?.is_admin) {
        return {
          name: "admin-export-cpo-list",
        };
      }

      return {
        name: "export-cpo-list",
      };
    },
    encodeCpoPageLink() {
      if (this.loggedUser?.is_admin) {
        return { name: "admin-encode-cpo" };
      }
      return { name: "encode-cpo" };
    },
    searchCpoLink() {
      if (this.loggedUser?.is_admin) {
        return { name: "admin-search-cpo" };
      }
      return { name: "search-cpo" };
    },
  },
  methods: {
    ...mapActions("auth", ["logOutUser"]),
    logOut() {
      axios.post("api/logout").then((response) => {
        // console.log(response.data);
        this.logOutUser();
        // this.$store.commit("auth/setIsLoggedIn", false);
        // this.$store.commit("auth/setUser", null);

        this.$router.push({
          name: "login-page",
        });
      });
    },
  },
};
</script>
<style scoped>
.export-btns-enter-from {
  opacity: 0;
  transform: translateY(-30px);
}

.export-btns-enter-active {
  transition: all 0.5s ease-out;
}
.export-btns-enter-to {
  opacity: 1;
  transform: translateY(0);
}

.export-btns-leave-from {
  opacity: 1;
  transform: translateY(0);
}

.export-btns-leave-active {
  transition: all 0.5s ease-in;
}
.export-btns-leave-to {
  opacity: 0;
  transform: translateY(-30px);
}
</style>
