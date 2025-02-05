<template>
  <div
    class="row"
    :style="{
      'background-image': 'url(images/login-bg.jpg)',
    }"
  >
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card login-container text-white">
          <div class="text-center p-5 pb-0">
            <h1>LOGIN</h1>
          </div>

          <form @submit.prevent="submitLoginForm" class="p-5 pt-1 m-5 mt-0">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input
                @input="toupperCase"
                id="username"
                type="text"
                class="form-control"
                :class="inputValidClasses"
                name="username"
                v-model="loginFormData.username"
                required
                autocomplete="username"
                autofocus
              />
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input
                id="password"
                type="password"
                class="form-control"
                :class="inputValidClasses"
                name="password"
                v-model="loginFormData.password"
                required
                autocomplete="current-password"
              />
            </div>
            <div class="mb-3" v-if="showError">
              <strong class="text-danger"> Invalid login </strong>
            </div>
            <div class="mb-3 form-check">
              <input
                class="form-check-input"
                type="checkbox"
                name="remember"
                id="remember"
              />
              <label class="form-check-label" for="remember">Remember me</label>
            </div>

            <div class="d-grid gap-2">
              <button
                v-if="!isValidating"
                type="submit"
                class="btn btn-primary"
              >
                Login
              </button>

              <button v-else class="btn btn-primary" type="button" disabled>
                <span
                  class="spinner-border spinner-border-sm"
                  role="status"
                  aria-hidden="true"
                ></span>
                Loading...
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from "vuex";
export default {
  inject: ["laravelData", "logPageVisit"],
  data() {
    return {
      loginFormData: {
        username: "",
        password: "",
      },
      isValidating: false,
      isError: false,
    };
  },

  methods: {
    ...mapActions("auth", ["setIsLoggedIn", "setUser"]),
    toupperCase() {
      this.loginFormData.username = this.loginFormData.username.toUpperCase();
    },
    async submitLoginForm() {
      this.isValidating = true;

      this.loginFormData.username = this.loginFormData.username.toLowerCase();
      this.loginFormData.password = this.loginFormData.password.toLowerCase();

      try {
        await axios.get("sanctum/csrf-cookie");
        const response = await axios.post("api/login", this.loginFormData);

        // console.log(response.data);
        this.setIsLoggedIn(true);
        this.setUser(response.data);

        this.$router.push({
          name: this.redirectLink,
        });
      } catch (error) {
        this.isValidating = false;
        this.isError = true;
        // console.log("error here");
        console.log(error.response.data.message);
      }
    },
  },
  computed: {
    redirectLink() {
      if (this.$store.getters["auth/loggedUser"].is_admin) {
        return "admin-search-cpo";
      }

      return "cpo-page";
    },
    inputValidClasses() {
      return {
        "is-invalid": this.showError,
      };
    },
    showError() {
      return this.isError && !this.isValidating;
    },
  },
  created() {
    /*
        if (this.$store.getters["auth/isLoggedIn"]) {
            this.$router.replace({
                name: "cpo-page",
            });
        }
        */
  },
  beforeCreate() {
    this.$store.commit("setMainPageTitleHeader", "Login");
  },
  mounted() {
    console.log(this.laravelData.side_bar_image);
    this.logPageVisit("login");
  },
};
</script>
<style scoped>
.row {
  height: 100vh;
  width: 100vw;
  background-size: cover;
}

.login-container {
  background-color: hsl(200, 100%, 6%, 0.5);
  box-shadow: 0 0 15px 0 hsl(200, 100%, 6%, 0.5);
  /* box-shadow: rgba(0, 0, 0, 0.5); */

  top: 10%;
}
</style>
