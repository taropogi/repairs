import { createApp } from "vue";

// For CPO program
import App from "./App.vue";
import router from "./router.js";
import store from "./store.js";
import Toast, { POSITION } from "vue-toastification";
import SideBar from "./components/SideBar/SideBar.vue";
import SpinnerLoading from "./components/UI/SpinnerLoading.vue";
import BaseModal from "./components/Modals/BaseModal.vue";
import "vue-toastification/dist/index.css";
const app = createApp(App);
app.use(router);
app.use(store);
app.use(Toast, {
  position: POSITION.BOTTOM_RIGHT,
  timeout: 1961,
});

app.component("side-bar", SideBar);
app.component("spinner-loading", SpinnerLoading);
app.component("base-modal", BaseModal);

app.config.unwrapInjectedRef = true;
// console.log(app.config);

app.mount("#app");
