require("./bootstrap");

import { createApp } from "vue";

// For CPO program
import App from "./apps/cpo/components/App.vue";
import router from "./apps/cpo/router.js";
import store from "./apps/cpo/store.js";

const app = createApp(App);

app.use(router);
app.use(store);

app.mount("#app");
