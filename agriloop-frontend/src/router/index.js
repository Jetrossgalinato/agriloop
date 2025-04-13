import { createRouter, createWebHistory } from "vue-router";
import LoginForm from "@/components/forms/LoginForm.vue"; // adjust path if needed
import Register from "../components/forms/RegisterForm.vue";
import Home from "@/components/page/Home.vue"; // your dashboard/homepage

const routes = [
  {
    path: "/",
    name: "Login",
    component: LoginForm,
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem("auth_token");
      if (token) {
        next("/home"); // Redirect to home if the user is already logged in
      } else {
        next(); // Allow access to the login page
      }
    },
  },
  {
    path: "/register",
    name: "Register",
    component: Register,
    beforeEnter: (to, from, next) => {
      const token = localStorage.getItem("auth_token");
      if (token) {
        next("/home"); // Redirect to home if the user is already logged in
      } else {
        next(); // Allow access to the login page
      }
    },
  },
  {
    path: "/home",
    name: "Home",
    component: Home,
    meta: { requiresAuth: true },
  },
  // add other routes here
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// 🔐 Auth Guard
router.beforeEach((to, from, next) => {
  const isAuthenticated = !!localStorage.getItem("auth_token");

  if (to.meta.requiresAuth && !isAuthenticated) {
    next({ name: "Login" }); // redirect to login if not authenticated
  } else {
    next(); // proceed
  }
});

export default router;
