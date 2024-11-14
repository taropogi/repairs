<template>
  <div class="container p-5">
    <form class="row g-3" v-if="user" @submit.prevent="submitUpdateForm">
      <div class="col-md-4">
        <label for="username" class="form-label">Username</label>
        <input
          type="text"
          class="form-control"
          id="username"
          name="username"
          v-model="user.username"
          :class="{
            'is-invalid': isUsernameInvalid,
          }"
          required
        />
      </div>
      <div class="col-md-4">
        <label for="name" class="form-label">Name</label>
        <input
          type="text"
          class="form-control"
          id="name"
          name="name"
          v-model="user.name"
          required
        />
      </div>

      <div class="col-md-4">
        <label for="email" class="form-label">Email</label>
        <input
          type="email"
          class="form-control"
          id="email"
          name="email"
          v-model="user.email"
        />
      </div>

      <div class="col-md-4">
        <label for="password" class="form-label">Password</label>
        <input
          type="password"
          class="form-control"
          id="password"
          v-model="user.password"
          :class="{
            'is-invalid': isPasswordInValid,
          }"
          name="password"
        />
      </div>

      <div class="col-md-4">
        <label for="confirm_password" class="form-label"
          >Confirm Password</label
        >
        <input
          type="password"
          class="form-control"
          name="password_confirmation"
          :class="{
            'is-invalid': isPasswordInValid,
          }"
          id="confirm_password"
          v-model="user.password_confirmation"
        />
      </div>
      <div class="col-4 d-flex align-items-center">
        <div class="form-check form-switch">
          <input
            class="form-check-input"
            type="checkbox"
            id="is-admin"
            v-model="user.is_admin"
          />
          <label class="form-check-label" for="is-admin"> Admin </label>
        </div>
      </div>
      <input-permissions v-model="user.permissions" />

      <div v-if="formErrors">
        <ul>
          <li
            class="text-danger"
            v-for="(ErrorValue, key) in formErrors"
            :key="'register-error' + ErrorValue + key"
          >
            <strong> {{ key }} </strong> -
            {{ ErrorValue }}
          </li>
        </ul>
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </form>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import InputPermissions from "./InputPermissions.vue";
export default {
  components: {
    InputPermissions,
  },
  props: ["id"],
  data() {
    return {
      user: null,
      formErrors: null,
    };
  },
  computed: {
    isUsernameInvalid() {
      if (this.formErrors && this.formErrors.username) {
        return true;
      }
      return false;
    },

    isPasswordInValid() {
      if (this.formErrors && this.formErrors.password) {
        return true;
      }
      return false;
    },
    // convert each permission to an object with a name property
    convertedPermissions() {
      return this.user.permissions.map((permission) => {
        return { name: permission };
      });
    },
  },
  methods: {
    async getUser() {
      try {
        const res = await axios.get("api/users/edit/" + this.id);

        this.user = res.data.user;
        this.user.is_admin = this.user.is_admin === 1;
        this.user.password = "";
        this.user.password_confirmation = "";
        this.user.permissions = this.user.permissions ?? [];
        console.log(this.user.permissions);
      } catch (error) {
        // console.log("errors");

        console.error(error.message);
      }
    },
    async submitUpdateForm() {
      // console.log(this.user);
      this.formErrors = null;
      try {
        const res = await axios.post("api/users/update", this.user);

        if (res.data.errors) {
          this.formErrors = res.data.errors;
          // console.log(this.formErrors);
        } else {
          this.$router.push({
            name: "admin-user-search",
          });
        }
      } catch (error) {
        console.log("errors");

        console.log(error);
      }
    },
    ...mapActions(["setActiveNav"]),
  },
  beforeCreate() {
    this.$store.commit("setMainPageTitleHeader", "Register");
  },
  mounted() {
    this.getUser();
    this.setActiveNav({
      nav: "admin-user-edit",
    });
  },
};
</script>

<style></style>
