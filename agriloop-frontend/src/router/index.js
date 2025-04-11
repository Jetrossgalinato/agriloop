import { createRouter, createWebHashHistory } from "vue-router";
import LoginForm from "../components/forms/LoginForm.vue";

const routes = [
  {
    path: "/",
    name: "Login",
    component: LoginForm,
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

export default router;
