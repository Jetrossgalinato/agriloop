import { createApp } from "vue";
import App from "./App.vue";
import router from "./router"; // import router
import "@mdi/font/css/materialdesignicons.css";

import vuetify from "./plugins/vuetify"; // if you're using Vuetify

const app = createApp(App);
app.use(router); // apply router
app.use(vuetify); // if Vuetify
app.mount("#app");
