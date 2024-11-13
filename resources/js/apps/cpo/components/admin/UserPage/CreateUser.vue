<template>
  <div class="m-5 shadow-lg p-3 mb-5 bg-body rounded">
    <form class="row g-3" @submit.prevent="submitRegisterForm">
      <div class="col-md-4">
        <label for="username" class="form-label">Username</label>
        <input
          type="text"
          class="form-control"
          id="username"
          name="username"
          v-model="formData.username"
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
          v-model="formData.name"
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
          v-model="formData.email"
        />
      </div>

      <div class="col-md-4">
        <label for="password" class="form-label">Password</label>
        <input
          type="password"
          class="form-control"
          id="password"
          v-model="formData.password"
          :class="{
            'is-invalid': isPasswordInValid,
          }"
          name="password"
          required
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
          required
          v-model="formData.password_confirmation"
        />
      </div>
      <div class="col-4 d-flex align-items-center">
        <div class="form-check form-switch">
          <input
            class="form-check-input"
            type="checkbox"
            id="is-admin"
            v-model="formData.isAdmin"
          />
          <label class="form-check-label" for="is-admin"> Admin </label>
        </div>
      </div>

      <input-permissions v-model="formData.permissions" />

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
        <button type="submit" class="btn btn-primary">Register</button>
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
  data() {
    return {
      formData: {
        name: "",
        username: "",
        password: "",
        password_confirmation: "",
        email: "",
        isAdmin: false,
        permissions: [],
      },
      formErrors: null,
    };
  },
  computed: {
    isUsernameInvalid() {
      if (this.formErrors?.username) {
        return true;
      }
      return false;
    },

    isPasswordInValid() {
      if (this.formErrors?.password) {
        return true;
      }
      return false;
    },
  },
  methods: {
    async submitRegisterForm() {
      this.formErrors = null;
      try {
        console.log(this.formData.permissions);
        const res = await axios.post("api/register", this.formData);
        console.log(res.data);
        if (res.data.errors) {
          this.formErrors = res.data.errors;
          // console.log(this.formErrors);
        } else {
          this.$router.push({
            name: "admin-user-search",
          });
        }
      } catch (error) {
        // console.log("errors");
        console.error(error.message);
      }
    },
    ...mapActions(["setActiveNav"]),
  },
  beforeCreate() {
    this.$store.commit("setMainPageTitleHeader", "Register");
  },
  mounted() {
    this.setActiveNav({
      nav: "admin-user-create",
    });
  },
};
</script>

<style></style>
