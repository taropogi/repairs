import { createApp } from "vue";

// For CPO program
import App from "./App.vue";
import router from "./router.js";
import store from "./store.js";
const app = createApp(App);
app.use(router);
app.use(store);

// app.config.unwrapInjectedRef = true;
// console.log(app.config);

app.mount("#app");
