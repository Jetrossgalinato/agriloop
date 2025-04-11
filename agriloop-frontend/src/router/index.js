import { createRouter, createWebHistory } from "vue-router";
import LoginForm from "@/components/forms/LoginForm.vue"; // adjust path if needed
import Home from "@/components/page/Home.vue"; // your dashboard/homepage

const routes = [
  {
    path: "/",
    name: "Login",
    component: LoginForm,
  },
  {
    path: "/home",
    name: "Home",
    component: Home,
  },
  // add other routes here
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
