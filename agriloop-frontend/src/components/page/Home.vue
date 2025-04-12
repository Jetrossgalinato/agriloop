<template>
  <h1>This is the Home page</h1>
  <v-list-item
    prepend-icon="mdi-logout"
    title="Logout"
    class="sidebar-text"
    @click="logout"
  ></v-list-item>
</template>
<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
const router = useRouter();
const logout = () => {
  localStorage.removeItem("auth_token"); // Clear the token
  localStorage.removeItem("user_id"); // Clear the user ID
  router.push("/"); // Redirect to login
};
</script>
<style scoped></style>
