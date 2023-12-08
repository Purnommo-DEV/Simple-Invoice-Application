import "./bootstrap";

// createApp itu default tidak bisa di ganti, jika diganti maka tampilannya tidak akan muncul
import { createApp } from "vue";

import app from "./components/app.vue";

import router from "./router/router";

createApp(app).use(router).mount("#app");
