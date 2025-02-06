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
        >
          <span class="nowrap fw-bold">
            <i class="bi bi-search me-2"></i> SEARCH CPO
          </span>
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
        >
          <span class="nowrap fw-bold">
            <i class="bi bi-pencil-square me-2"></i> ENCODE CPO
          </span>
        </router-link>
      </li>
      <li>
        <router-link
          :to="linkExportCpo"
          class="nav-link text-white"
          :class="{ active: isNavExportActive }"
        >
          <span class="nowrap fw-bold">
            <i class="bi bi-box-arrow-up me-2"></i> EXPORT CPO LIST
          </span>
        </router-link>
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
    <!-- <transition
      v-show="isNavSearchActive"
      name="general-transition"
      class="mt-auto"
    >
      <random-qoute></random-qoute>
    </transition> -->
    <transition name="general-transition">
      <div
        v-if="isNavUpdateActive && !userIsAdmin"
        class="alert alert-info d-flex align-items-center my-2"
        role="alert"
      >
        <div>
          <h4 class="fw-bold">
            <i class="bi bi-info-circle me-2"></i>
            NOTES FOR UPDATING
          </h4>
          <hr />
          <strong>
            <i class="bi bi-person-check me-2"></i>
            CUSTOMER SELECTION</strong
          >
          <p class="my-2">
            You can select oracle customer by selecting the "Choose oracle
            customer" option. This will automatically fill the customer name and
            address fields.
          </p>
          <p class="my-2">
            If you select N/A, you can manually input the customer name and
            address.
          </p>
          <strong
            ><i class="bi bi-pencil-square me-2"></i> FOR UPDATING LINES</strong
          >
          <p class="my-2">
            For updating line details, you can only access/update specific
            fields. Fields you cannot access/update are grayed out.
          </p>
          <strong class="my-2"
            ><i class="bi bi-chat-left-text me-2"></i> LINE COMMENTS</strong
          >
          <p class="my-2">
            You can put your own comments for each line. Other comments by other
            users will be visible below the input field.
          </p>
          <strong>
            <i class="bi bi-box-seam me-2"></i>
            ITEM SELECTION</strong
          >
          <p class="my-2">
            You can select a specific item from the oracle item list by clicking
            the
            <button class="btn btn-secondary btn-sm">...</button>
            button.
          </p>
          <p>You can also put the item's segment6 in th field.</p>
          <p>This will automatically fill the description and unit fields.</p>
        </div>
      </div>
    </transition>
    <transition name="note-encoding">
      <div
        v-if="isNavEncodeActive && !userIsAdmin"
        class="alert alert-info d-flex align-items-center my-2"
        role="alert"
      >
        <div>
          <h4 class="fw-bold">
            <i class="bi bi-info-circle me-2"></i>
            NOTES FOR ENCODING
          </h4>
          <hr />
          <strong>
            <i class="bi bi-person-check me-2"></i>
            CUSTOMER SELECTION</strong
          >
          <p class="my-2">
            You can select oracle customer by selecting the "Choose oracle
            customer" option. This will automatically fill the customer name and
            address fields.
          </p>
          <p class="my-2">
            If you select N/A, you can manually input the customer name and
            address.
          </p>

          <strong>
            <i class="bi bi-box-seam me-2"></i>
            ITEM SELECTION</strong
          >
          <p class="my-2">
            You can select a specific item from the oracle item list by clicking
            the
            <button class="btn btn-secondary btn-sm">...</button>
            button.
          </p>
          <p>You can also put the item's segment6 in th field.</p>
          <p>This will automatically fill the description and unit fields.</p>
        </div>
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
// import RandomQoute from "./RandomQoute.vue";
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
    // RandomQoute,
  },
  data() {
    return {};
  },
  computed: {
    ...mapGetters(["activeNav"]),
    ...mapGetters("auth", ["isLoggedIn", "loggedUser", "canEditCpo"]),
    ...mapGetters("cpo", ["selectedPos"]),

    selectedPosCount() {
      return this.selectedPos.length;
    },

    isNavSearchActive() {
      return this.activeNav?.nav === "search-cpo" ? true : false;
    },
    isNavUpdateActive() {
      return this.activeNav?.nav === "edit-cpo" ? true : false;
    },
    isNavExportActive() {
      return this.activeNav?.nav === "export-cpo" ? true : false;
    },
    isNavEncodeActive() {
      return this.activeNav?.nav === "encode-cpo" ? true : false;
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
.general-transition-enter-from,
.note-encoding-enter-from {
  opacity: 0;
  transform: translateY(-30px);
}

.general-transition-enter-active,
.note-encoding-enter-active {
  transition: all 0.5s ease-out;
}
.general-transition-enter-to,
.note-encoding-enter-to {
  opacity: 1;
  transform: translateY(0);
}

/* .general-transition-leave-from,
.note-encoding-leave-from {
  opacity: 1;
  transform: translateY(0);
}

.general-transition-leave-active,
.note-encoding-leave-active {
  transition: all 0.5s ease-in;
}
.general-transition-leave-to,
.note-encoding-leave-to {
  opacity: 0;
  transform: translateY(-30px);
} */

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

/* .export-btns-leave-from {
  opacity: 1;
  transform: translateY(0);
}

.export-btns-leave-active {
  transition: all 0.5s ease-in;
}
.export-btns-leave-to {
  opacity: 0;
  transform: translateY(-30px);
} */
</style>
